<?php

namespace CrystalCode\Php\Common\Injectors;

final class BTest
{

    /**
     *
     * @var ATest
     */
    private $aTest;

    /**
     * 
     * @param ATest $aTest
     */
    public function __construct(ATest $aTest)
    {
        $this->aTest = $aTest;
    }

    /**
     * 
     * @return ATest
     */
    public function getATest(): ATest
    {
        return $this->aTest;
    }

}
