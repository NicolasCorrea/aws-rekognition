<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Rekognition\RekognitionClient;

class AwsRekognition extends Controller
{
    public function TextDetect()
    {
        $options = [
            'profile' => "default",
            'region' => 'us-west-2',
            'version' => 'latest',
        ];

        $rekognition = new RekognitionClient($options);

        // Get local image
        $photo = public_path().'/img/text-lorem.jpg';
        $fp_image = fopen($photo, 'r');
        $image = fread($fp_image, filesize($photo));
        fclose($fp_image);

        // Call DetectFaces
        $result = $rekognition->detectText(array(
            'Image' => array(
                'Bytes' => $image,
            ),
            'Attributes' => array('ALL'),
        )
        );

        // Display info for each detected person
        // print 'People: Image position and estimated age' . "<>";
        // dd($result);
        // dump($result->data);
        // dump($result["TextDetections"]);
        for ($i=0; $i < count($result["TextDetections"]); $i++) {
            $data = $result["TextDetections"][$i];
            // if($data["Type"] == "LINE"){
                echo $data["DetectedText"]."<br>";
            // }
        }
    }
    public function FaceComparation(Request $request)
    {
        $options = [
            'profile' => "default",
            'region' => 'us-west-2',
            'version' => 'latest',
        ];

        $rekognition = new RekognitionClient($options);

        // Get local image
        // if($request->file("file1")){

        // }else{
        $image1 = substr($request->get("data1"),22, strlen($request->get("data1")));
        $image2 = substr($request->get("data2"),22, strlen($request->get("data2")));
        $bin = base64_decode($image1);
        $im1 = imageCreateFromString($bin);
        $image1 = public_path().'/img/image1.png';
        imagepng($im1, $image1, 0);
        $bin = base64_decode($image2);
        $im2 = imageCreateFromString($bin);
        $image2 = public_path().'/img/image2.png';
        imagepng($im2, $image2, 0);

        // }
        $photo1 = $image1;
        $fp_image1 = fopen($photo1, 'r');
        $image1 = fread($fp_image1, filesize($photo1));
        fclose($fp_image1);
        $photo2 = $image2;
        $fp_image2 = fopen($photo2, 'r');
        $image2 = fread($fp_image2, filesize($photo2));
        fclose($fp_image2);
        // $photo1 = $request->file("file1")->getPathname();
        // $fp_image1 = fopen($photo1, 'r');
        // $image1 = fread($fp_image1, filesize($photo1));
        // fclose($fp_image1);
        // $photo2 = $request->file("file2")->getPathname();
        // $fp_image2 = fopen($photo2, 'r');
        // $image2 = fread($fp_image2, filesize($photo2));
        // fclose($fp_image2);
        // Call DetectFaces
        $result = $rekognition->compareFaces([
            'QualityFilter' => 'HIGH',
            'SimilarityThreshold' => 50,
            'SourceImage' => [
                'Bytes' => $image1,
            ],
            'TargetImage' => [
                'Bytes' => $image2,
            ],
        ]);
        return response()->json(["original" => $result["SourceImageFace"], "coincidencias" => $result["FaceMatches"]]);

    }
}
