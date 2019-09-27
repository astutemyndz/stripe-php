<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Stripe\Stripe as StripePaymentGetway;
use Stripe\PaymentIntent;
use Illuminate\Http\Response;
class StripeController extends CI_Controller {
    private $response;
    private $intent;
    public function __construct()
    {
        parent::__construct();
        $this->init();
    }
    public function setResponse($response) {
        $this->response = $response;
        return $this;
    }
    public function getResponse() {
        return $this->response;
    }
    public function sendResponse() {
        $this->response->send();
    }
    //https://stripe.com/docs/api/payment_intents/list
    public function init() {
        StripePaymentGetway::setApiKey("pk_test_9X1Edj5lTitMBPOAzC1Q2xcV");
    }
    public function paymentIntents() {
        try {
            $this->intent = PaymentIntent::all(["limit" => 3]);
            $this->setResponse(new Response(
                array(
                    'data' => $this->intent,
                    'status' => Response::HTTP_OK,
                    'message' => Response::$statusTexts[200]
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        } catch(\Exception $ex) {
            $this->setResponse(new Response(
                array(
                    'data' => [],
                    'status' => Response::HTTP_OK,
                    'message' => $ex->getMessage()
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        }
        
        
        $this->sendResponse();
    }
}
