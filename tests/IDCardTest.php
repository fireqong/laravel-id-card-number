<?php


namespace Church\IDCard\Tests;


use Church\IDCard\IDCard;
use PHPUnit\Framework\TestCase;

class IDCardTest extends TestCase
{
    public function identifyNumberProvider()
    {
        return [
            ['130928198905281793', '130928', '男', '179', '3', '19890528', '河北省沧州市吴桥县'],
            ['513221197102183838', '513221', '男', '383', '8', '19710218', '四川省阿坝藏族羌族自治州汶川县'],
            ['610523198305134774', '610523', '男', '477', '4', '19830513', '陕西省渭南市大荔县'],
            ['350822197101183592', '350822', '男', '359', '2', '19710118', '福建省龙岩市永定县'],
            ['522425198109113949', '522425', '女', '394', '9', '19810911', '贵州省毕节地区织金县'],
            ['36100119860426330X', '361001', '女', '330', 'X', '19860426', '江西省抚州市市辖区'],
        ];
    }

    public function invalidIdentifyNumberProvider()
    {
        return [
            ['fjadlfjdaklfjdjla'],
            ['36232919980110555X'],
            ['36232919910727452X'],
        ];
    }

    /**
     * @dataProvider identifyNumberProvider
     * @param $identifyNumber
     * @param $code
     * @param $sex
     * @param $sequence
     * @param $CRC
     * @param $birthday
     * @param $address
     */
    public function testValid($identifyNumber, $code, $sex, $sequence, $CRC, $birthday, $address)
    {
        $IDCard = new IDCard($identifyNumber);

        $this->assertEquals($code, $IDCard->getCode());
        $this->assertEquals($sex, $IDCard->getSex());
        $this->assertEquals($sequence, $IDCard->getSequenceCode());
        $this->assertEquals($CRC, $IDCard->getCRC());
        $this->assertEquals($birthday, $IDCard->getBirthday());
        $this->assertEquals($address, $IDCard->getAddress());
        $this->assertTrue($IDCard->isValid());
    }

    /**
     * @dataProvider invalidIdentifyNumberProvider
     * @param $identifyNumber
     */
    public function testInvalid($identifyNumber)
    {
        $IDCard = new IDCard($identifyNumber);

        $this->assertFalse($IDCard->isValid());
    }
}