<?php

namespace CrystalCode\Php\Common\Injectors;

final class CTest
{

    /**
     *
     * @var BTest
     */
    private $bTest;

    /**
     *
     * @var CTest
     */
    private $cTest;

    /**
     * 
     * @param BTest $bTest
     * @param CTest $cTest
     */
    public function __construct(BTest $bTest, CTest $cTest)
    {
        $this->bTest = $bTest;
        $this->cTest = $cTest;
    }

    /**
     * 
     * @return BTest
     */
    public function getBTest(): BTest
    {
        return $this->bTest;
    }

    /**
     * 
     * @return CTest
     */
    public function getCTest(): CTest
    {
        return $this->cTest;
    }

}
