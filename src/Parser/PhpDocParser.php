<?php

namespace Butterfly\Component\Annotations\Parser;

class PhpDocParser implements IPhpDocParser
{
    /**
     * @param string $phpDoc
     * @return array
     */
    public function parse($phpDoc)
    {
        $phpDocBody  = $this->extractPhpDocBody($phpDoc);
        $phpDocLines = $this->extractPhpDocLines($phpDocBody);

        return $this->extractAnnotations($phpDocLines);
    }

    /**
     * @param string $str
     * @return string
     */
    protected function extractPhpDocBody($str)
    {
        $str = trim($str);
        $str = str_replace('*', '', $str);
        $str = substr($str, 1, -1);
        $str = trim($str);

        return $str;
    }

    /**
     * @param string $phpDocBody
     * @return array
     */
    protected function extractPhpDocLines($phpDocBody)
    {
        $strs = explode("\n", $phpDocBody);

        $index          = 0;
        $annotationsRaw = array();

        foreach ($strs as $str) {
            $str = trim($str);

            $startPosition = strpos($str, '@');

            if (false === $startPosition && !empty($str)) {
                if (!array_key_exists($index, $annotationsRaw)) {
                    $annotationsRaw[$index] = '';
                }

                $annotationsRaw[$index] .= ' ' . $str;
            } else {
                $index++;
                $annotationsRaw[$index] = $str;
            }
        }

        return array_filter($annotationsRaw);
    }

    /**
     * @param array $phpDocLines
     * @return array
     */
    protected function extractAnnotations(array $phpDocLines)
    {
        $annotations      = array();
        $annotationsCount = array();

        foreach ($phpDocLines as $phpDocLine) {
            if (!$this->isAnnotationLine($phpDocLine)) {
                continue;
            }

            $annotationBody       = $this->extractAnnotationBody($phpDocLine);
            list($key, $rawValue) = $this->separateAnnotationKeyAndValue($annotationBody);

            if (array_key_exists($key, $annotationsCount)) {
                $annotationsCount[$key]++;
            } else {
                $annotationsCount[$key] = 1;
            }

            if ($annotationsCount[$key] == 1) {
                $annotations[$key] = $this->parseAnnotationValue($rawValue);
            } elseif ($annotationsCount[$key] == 2) {
                $annotations[$key] = array($annotations[$key], $this->parseAnnotationValue($rawValue));
            } else {
                $annotations[$key][] = $this->parseAnnotationValue($rawValue);
            }
        }

        return $annotations;
    }

    /**
     * @param string $phpDocLine
     * @return bool
     */
    protected function isAnnotationLine($phpDocLine)
    {
        return false !== strpos($phpDocLine, '@');
    }

    /**
     * @param string $phpDocLine
     * @return null|string
     */
    protected function extractAnnotationBody($phpDocLine)
    {
        $atPosition = strpos($phpDocLine, '@');

        return false !== $atPosition
            ? trim(substr($phpDocLine, $atPosition + 1))
            : '';
    }

    /**
     * @param string $str
     * @return array
     */
    protected function separateAnnotationKeyAndValue($str)
    {
        return substr_count($str, ' ') > 0
            ? explode(' ', $str, 2)
            : array($str, null);
    }

    /**
     * @param string $value
     * @return mixed
     */
    protected function parseAnnotationValue($value)
    {
        $result = json_decode($value, true);

        return null === $result ? $value : $result;
    }
}
