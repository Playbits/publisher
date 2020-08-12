<?php
class ApiCest 
{    
    public function tryApi(ApiTester $I)
    {
        $I->sendGET('/');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
    }
    public function trySubscription(ApiTester $I)
    {
        $I->sendPOST('/subscribe/topic1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
    public function trPublish(ApiTester $I)
    {
        $I->sendPOST('/publish/topic1');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}