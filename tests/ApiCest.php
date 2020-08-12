<?php
class ApiCest {
    public function tryApi(ApiTester $I) {
        $I->sendGET('/');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
    }
    public function trySubscription(ApiTester $I) {
        $I->sendPOST('/subscribe/topic1', [
            "url" => "http://localhost:8000/event",
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
    public function trPublish(ApiTester $I) {
        $I->sendPOST('/publish/topic1', [
            "message" => "This message will be broadcasted to all the urls in topic file",
        ]);
        $I->seeResponseCodeIs(200);
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
        $I->seeResponseIsJson();
    }
}