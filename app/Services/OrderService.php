<?php namespace App\Services;

use App\Models\Entities\Order;
use Illuminate\Http\Request;
use App\Models\Repositories\UserRepositoryInterface;
use App\Models\Repositories\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService {

    private $currencyRepo;
    private $userRepo;
    private $request;
    private $currency;
    private $user;
    private $order;
    private $userService;
    private $orderMessage = 'Your purchase was successful. Thank you!';

    public function __construct(
        Request $request,
        CurrencyRepositoryInterface $currencyRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->currencyRepo = $currencyRepo;
        $this->userRepo = $userRepo;
        $this->request = $request;
        $this->userService = new UserService($this->userRepo);
    }

    /**
     * Creates a new order
     * @return string
     * @throws \Exception
     */
    public function createOrder () {
        try {
            DB::transaction(function () {
                // create new order object
                $this->order = Order::create();
                $this->order->foreign_currency_amount = $this->request->foreign_input != 0 ? floatval($this->request->foreign_input) : floatval($this->request->total_foreign_buying_zar);
                $this->order->zar_amount = floatval($this->request->total_zar_value);

                // get the currency object
                $this->currency = $this->currencyRepo->getByCode($this->request->foreign_currency_code);
                $this->order->currency_id = $this->currency->id;
                $this->order->exchange_rate = $this->currency->exchange_rate;

                // apply the surcharge
                $this->currency->applySurcharge($this->order);

                // apply the discount
                $this->currency->applyDiscount($this->order);

                // if an email was provided get the user object or create if it doesn't exist
                // and set the order user_id
                if (isset($this->request->user_email)) {
                    $this->user = $this->userService->getUser($this->request->user_email);
                    $this->order->user_id = $this->user->id;
                }

                $this->order->update();
            });

            CurrencyStrategy::sendEmail($this->currency);

            return $this->orderMessage;
        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Sends an order email to the user
     */
    public function sendOrderEmail() {
        Mail::send([], [], function ($message) {
            $body = "Hi, please find your order purchase details:\r\n
    Exchange Rate: {$this->currency->exchange_rate}
    Foreign Currency Amount: {$this->currency->code } {$this->order->foreign_currency_amount}
    ZAR Amount: R " . number_format($this->order->zar_amount, 2) ."
    Surcharge Percentage: {$this->order->surcharge_percentage}%
    Surcharge Amount: R " . number_format($this->order->surcharge_amount, 2) . "
    Discount Percentage: {$this->order->discount_percentage}%
    Discount Amount: {$this->order->discount_amount}
    Total Amount Paid: R " . number_format($this->order->total_amount, 2);

            $message->from('charlbeukes@gmail.com', 'Mukuru Foreign Currencies Test')
                    ->to($this->user->email)
                    ->subject('Your order from Mukuru Foreign Currencies')
                    ->setBody($body);
        });
    }
}