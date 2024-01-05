<?php
declare(strict_types=1);

namespace Bjm0001\Utils;

class Number
{
    /**
     * 科学记数法转数字
     * 3500000 可以表示为 3.5*10的6次方
     * 0.000045 可以表示为 4.5*10的负5次方
     * 科学记数法通常以类似于 1.23e5 或 2.45E-3 的形式表示，其中 e 或 E 后面的数字表示指数。
     * 例如，1.23e5 表示1.23*10的五次方，而2.45E-3 表示2.45*10的负三次方
     * @param string $number
     * @return string
     */
    public static function scToNum(string $number): ?string
    {
        if (stripos($number, 'e') === false) {
            return $number;
        }
        if (!preg_match("/^([\\d.]+)[eE]([\\d\\-\\+]+)$/", str_replace(array(" ", ","), "", trim($number)), $matches)) {
            return $number;
        }
        $data = preg_replace(array("/^[0]+/"), "", rtrim($matches[1], "0."));
        if ($data === null) {
            return $number;
        }
        $length = (int)$matches[2];
        if ($data[0] === ".") {
            $data = "0{$data}";
        }

        if ($length === 0) {
            return $data;
        }

        $dot_position = strpos($data, ".");
        if ($dot_position === false) {
            $dot_position = strlen($data);
        }
        $data = str_replace(".", "", $data);
        if ($length > 0) {
            $repeat_length = $length - (strlen($data) - $dot_position);
            if ($repeat_length > 0) {
                $data .= str_repeat('0', $repeat_length);
            }
            $dot_position += $length;
            $data = ltrim(substr($data, 0, $dot_position), "0") . "." . substr($data, $dot_position);
        } elseif ($length < 0) {
            $repeat_length = abs($length) - $dot_position;
            if ($repeat_length > 0) {
                $data = str_repeat('0', $repeat_length) . $data;
            }
            $dot_position += $length;//此处length为负数，直接操作
            if ($dot_position < 1) {
                $data = ".{$data}";
            } else {
                $data = substr($data, 0, $dot_position) . "." . substr($data, $dot_position);
            }
        }
        if ($data[0] === ".") {
            $data = "0{$data}";
        }

        return trim($data, ".");
    }

    /**
     * 转科学技术法
     * @param string $number
     * @return string
     */
    public static function numToSc(string $number): string
    {
        // 使用 sprintf 获取科学记数法字符串
        $tmp1 = explode('.',$number);

        $decimalCount = isset($tmp1[1]) ? strlen($tmp1[1]) : 0;
        $precision = (strlen($tmp1[0]) + $decimalCount) - 1;
        $scientificNotation = strtolower(sprintf("%.{$precision}e", $number));
        //移除除无效0
        $tmp = explode('e',$scientificNotation);
        $tmp[0] = rtrim($tmp[0],'0');
        $scientificNotation = implode('e',$tmp);


        // 获取指数部分
        preg_match('/e([+-]?\d+)$/', $scientificNotation, $matches);
        $exponent = (int)($matches[1] ?? 0);

        // 去掉指数部分的无效零
        $exponentPart = 'e' . ($exponent < 0 ? $exponent : '+' . $exponent);
        return str_replace($exponentPart, 'e' . $exponent, $scientificNotation);
    }
}