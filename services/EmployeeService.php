<?php

namespace app\services;

use app\repositories\YiiEmployeeRepository;

class EmployeeService
{
    public $yiiEmployeeRepository;
    public function __construct(YiiEmployeeRepository $yiiEmployeeRepository)
    {
        $this->yiiEmployeeRepository = $yiiEmployeeRepository;
    }

    public function getName()
    {
        return 'Nika' . $this->yiiEmployeeRepository->getNumber();
    }
}
