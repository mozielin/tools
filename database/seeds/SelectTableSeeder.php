<?php

use Illuminate\Database\Seeder;
use App\Select;

class SelectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Select::create(['header' => '訂單編號']);
        Select::create(['header' => '訂單金額']);
        Select::create(['header' => '付款日期']);
        Select::create(['header' => '貨到付款金額']);
        Select::create(['header' => '預計出貨日']);
        Select::create(['header' => '統一編號']);
        Select::create(['header' => '物流公司']);
        Select::create(['header' => '超商代碼']);
        Select::create(['header' => '配送時段']);
        Select::create(['header' => '備註']);
        Select::create(['header' => '商品名稱']);
        Select::create(['header' => '商品條碼']);
        Select::create(['header' => '商品單價']);
        Select::create(['header' => '出貨-郵遞區號']);
        Select::create(['header' => '出貨-地址']);
        Select::create(['header' => '出貨-電話']);
        Select::create(['header' => '出貨-姓名']);
        Select::create(['header' => '出貨-email']);
        Select::create(['header' => '是否開立發票']);
        Select::create(['header' => '捐贈碼']);
        Select::create(['header' => '是否列印發票']);
        Select::create(['header' => '載具類別']);
        Select::create(['header' => '載具編號']);
        Select::create(['header' => '發票稅別']);
        Select::create(['header' => '通關方式']);
        Select::create(['header' => '信用卡末四碼']);
        Select::create(['header' => '購買人-郵遞區號']);
        Select::create(['header' => '購買人-地址']);
        Select::create(['header' => '購買人-電話']);
        Select::create(['header' => '購買人-姓名']);
        Select::create(['header' => '購買人-email']);

    }
}
