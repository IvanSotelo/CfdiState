<?php

namespace IvanSotelo\CfdiState\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use IvanSotelo\CfdiState\CfdiStateServiceProvider;
use IvanSotelo\CfdiState\CFDIState;

class TestCaseTest extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CfdiStateServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.debug', true);
        $app['config']->set('app.locale', 'es');
    }

     public function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_be_return_expression()
    {
        $expresion = 'https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=9E1D19A8-A7C4-4879-AEB1-E6F4DD300946&re=CTE180828E84&rr=SAP0108228V3&tt=5800.0&fe=LrCQBA==';
        $cfdi = new CFDIState('test.xml');
        $this->assertSame($expresion, $cfdi->getExpression());
    }

    public function test_can_be_return_status()
    {
        $cfdi = new CFDIState('test.xml');
        $this->assertSame('active', $cfdi->getSatStatus()->cfdi_status);
    }

    public function test_cant_be_return_status()
    {
        $cfdi = new CFDIState('test_fail.xml');
        $this->assertSame('not_found', $cfdi->getSatStatus()->cfdi_status);
    }

    public function test_cant_be_get_file()
    {
        $cfdi = new CFDIState('test_fail3.xml');
        dd($cfdi->getSatStatus());
        $this->assertSame('not_found', $cfdi->getSatStatus()->cfdi_status);
    }
}