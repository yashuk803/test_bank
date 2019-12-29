<?php

namespace app\controllers;

use app\repositories\contracts\ClientDepositRepository;
use app\repositories\contracts\HistoryTransactionRepository;
use app\services\ChargeCommission;
use app\services\InterestAccrual;
use yii\filters\AccessControl;
use yii\web\Controller;

class SiteController extends Controller
{

    private $interestAccrual;
    private $chargeCommission;
    private $historyTransactionRepository;
    private $clientDepositRepository;

    public function __construct(
        $id,
        $module,
        ChargeCommission $chargeCommission,
        InterestAccrual $interestAccrual,
        HistoryTransactionRepository $historyTransactionRepository,
        ClientDepositRepository $clientDepositRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->interestAccrual = $interestAccrual;
        $this->chargeCommission = $chargeCommission;
        $this->historyTransactionRepository = $historyTransactionRepository;
        $this->clientDepositRepository = $clientDepositRepository;

    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['run-cron'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index',[
            'itemStatistic' => $this->historyTransactionRepository->getStatisticByMonth(),
            'groupAverage' => $this->clientDepositRepository->averageDepositAmountByGroup(),
        ]);
    }

    public function actionRunCron()
    {
        $this->interestAccrual->execute();

        if(\date('j', \strtotime(date('Y-m-d'))) === 1) {
            $this->chargeCommission->execute();
        }
    }

}
