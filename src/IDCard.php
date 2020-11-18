<?php


namespace Church\IDCard;

/**
 * 校验身份证是否合法
 * Class IDCard
 * @package Church\IDCard
 */
class IDCard
{
    protected $id;

    protected $code = '';

    protected static $regions = [];

    /**
     * 系数
     * @var int[]
     */
    protected $coefficient = [
        7,
        9,
        10,
        5,
        8,
        4,
        2,
        1,
        6,
        3,
        7,
        9,
        10,
        5,
        8,
        4,
        2
    ];

    /**
     * 余数列表
     * @var array
     */
    protected $remainder = [
        1,
        0,
        'X',
        9,
        8,
        7,
        6,
        5,
        4,
        3,
        2
    ];

    /**
     * IDCard constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->setId($id);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = strtoupper($id);
    }

    /**
     * 身份证是否有效
     * @return bool
     */
    public function isValid(): bool
    {
        if (strlen($this->id) != 18) {
            return false;
        }
        
        $regions = self::getRegionCode();
        $code = $this->getCode();
        $remainder = $this->getRemainder();
        $CRC = $this->getCRC();

        if (isset($regions[$code]) && $CRC == $this->remainder[$remainder]) {
            return true;
        }

        return false;
    }

    /**
     * 获取行政代码
     * @return string
     */
    public function getCode(): string
    {
        if (! $this->code) {
            $this->code = substr($this->id, 0, 6);
        }

        return $this->code;
    }

    /**
     * 获取生日
     * @return string
     */
    public function getBirthday(): string
    {
        return substr($this->id, 6, 8);
    }

    /**
     * 获取顺序码
     * @return string
     */
    public function getSequenceCode(): string
    {
        return substr($this->id, 14, 3);
    }

    /**
     * 获取校验码
     * @return string
     */
    public function getCRC(): string
    {
        return substr($this->id, 17, 1);
    }

    /**
     * 获取行政代码对应的省市区地址
     * @return string
     */
    public function getAddress(): string
    {
        $regions = self::getRegionCode();
        $code = $this->getCode();
        [$provinceCode, $cityCode] = $this->getProvinceAndCityCode();
        return $regions[$provinceCode] . $regions[$cityCode] . $regions[$code];
    }

    /**
     * 从身份证号中获取性别
     * @return string
     */
    public function getSex(): string
    {
        $sexBit = intval(substr($this->id, 16, 1));
        return is_float($sexBit / 2) ? '男' : '女';
    }

    /**
     * 获取行政代码数组
     * @return array
     */
    public static function getRegionCode(): array
    {
        if (! self::$regions) {
            self::$regions = file_get_contents(dirname(__FILE__) . '/../data/region.json');
            self::$regions = json_decode(self::$regions, true);
        }

        return self::$regions;
    }

    /**
     * 计算校验码
     * @return int
     */
    protected function getRemainder(): int
    {
        $sum = 0;
        $length = 17;
        $data = substr($this->id, 0, $length);

        for ($i = 0; $i < $length; $i++) {
            $sum += intval($data[$i]) * $this->coefficient[$i];
        }

        return $sum % 11;
    }

    /**
     * 获取省和市的行政代码
     * @return string[]
     */
    protected function getProvinceAndCityCode(): array
    {
        $code = $this->getCode();

        $cityCode = substr($code, 0, 4) . '00';
        $provinceCode = substr($code, 0, 2) . '0000';

        return [$provinceCode, $cityCode];
    }
}
