<?php
namespace App\Controller;
use GuzzleHttp\Client;
use Respect\Validation\Validator as V;

/*
 * This class is responsible for handling all media
 * Upload, Delete, Generate Thumbnails and Modify Files
 */
class PublisherController extends Controller {
    protected $data_path = __DIR__ . "/../../var/data/";

    public function subscribe($request, $response, $args) {
        $topic = $args['topic'];
        $validator = $this->requestValidator();
        $validation = $validator->validate($request, [
            'url' => V::url(),
        ]);
        $checkValidation = $this->checkValidation($validator);
        if ($checkValidation !== true) {
            return $this->responseWithJson($response, $checkValidation, 400);
        }
        $params = $request->getParsedBody();
        $params['topic'] = $topic;
        $saveTopic = $this->saveTopic($topic, $params);
        if ($saveTopic) {
            $output['message'] = "Topic saved";
        } else {
            $output['message'] = "Topic not saved";
        }
        $this->logger->info('subscription saved successfully');
        return $this->responseWithJson($response, $output);
    }

    public function publishTopic($request, $response, $args) {
        $params = $request->getParsedBody();
        $topic = $args['topic'];
        $topic_path = $this->data_path . $topic . ".json";
        $topic_file = $this->readJson($topic_path);
        $payload = array_merge($params, $topic_file);
        $output = [];
        // $postEventData = $this->postEventData($payload);
        // var_dump($postEventData);
        // exit();
        return $this->responseWithJson($response, $payload);
    }

    public function publishEvent($request, $response, $args) {
        $output = [];
        return $this->responseWithJson($response, $output);
    }

    private function saveTopic(String $topic, $data) {
        $topic_path = $this->data_path . $topic . ".json";
        $saveFile = $this->saveJson($data, $topic_path);
        return $saveFile;
    }

    private function postEventData($data) {
        $url = $data['url'];
        $client = new Client([
            'base_uri' => "http://localhost:8000",
            // 'defaults' => [
            //     'exceptions' => false,
            // ],
        ]);
        unset($data['url']);
        $API_response = $client->request('POST', '/event', [
            'json' => $data,
        ]);
        return $API_response;
        // $responseData = json_decode($API_response->getBody()->getContents(), true);
        // return $responseData;
    }
}
