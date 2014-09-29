<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/26/14
 * Time: 9:21 AM
 */

namespace User\Helper;

use Zend\File\Transfer\Adapter\Http;
use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

class PictureHelper {

    const UPLOAD_FOLDER = '/../../../../public/media/accounts';
    const LONG_URL_DIR = '/media/accounts';
    const PICTURE_WIDTH = 500;
    const MINIMUM_PICTURE_WIDTH = 100;
    const MAXIMUM_PICTURE_SIZE = 10485760;

    /**
     * @param $file
     * @param $accountId
     * @throws \Exception
     */
    public function addPictureFromRequest($file, $accountId){
        $picture = $file->get('file');

        $adapter = new Http();
        $size = new Size(array('max' => $this::MAXIMUM_PICTURE_SIZE ));
        //$extension = new Extension(array('extension' => array('jpeg', 'jpg', 'gif', 'tiff', 'png', 'bmp')));
        $adapter->setValidators(array($size), $picture['name']);

        if(!$adapter->isValid()){

            $errors = $adapter->getMessages();
            $message = '';

            foreach ($errors as $error) {
                $message .= $error;
                break;
            }

            throw new \Exception($message);
        }

        $tmpFileUrl = $accountId.'_logo.jpg';

        $destinationFolder =  dirname(__DIR__).$this::UPLOAD_FOLDER;
        $destinationFile = $destinationFolder."/".$tmpFileUrl;

        if(!file_exists($destinationFolder)){
            mkdir($destinationFolder);
        }

        $adapter->addFilter('Rename',  array(
                'target' => $destinationFile,
                'overwrite' => true)
        );

        if (!$adapter->receive($picture['name'])) {
            throw new \Exception("An error was found while uploading the picture");
        }

    }


    /**
     * @param $original
     * @param $destination
     * @param $width
     * @throws \Exception
     */
    public function resizeImage($original, $destination, $width){

        $imagine = new Imagine();
        $image = $imagine->open($original);

        $actualSize = $image->getSize();
        $actualWidth = $actualSize->getWidth();
        $actualHeight = $actualSize->getHeight();

        if($actualWidth > $width){
            $rate = $actualHeight / $actualWidth;
            $height = floor($width * $rate);

            //$image->resize(new Box($width, $height))
            $image->save($destination);
        }
        elseif($actualWidth < $this::MINIMUM_PICTURE_WIDTH){
            throw new \Exception("The picture is smaller than expected");
        }
        else{
            $image->save($destination);
        }

        unlink($original);
    }

    /**
     * @param $accountId
     * @return string
     */
    public function getPictureUrlFromAccount($accountId)
    {
        $url = self::LONG_URL_DIR."/".$accountId."_logo.jpg";
        if(!file_exists(dirname(__DIR__).self::UPLOAD_FOLDER."/".$accountId."_logo.jpg"))
        {
            return null;
        }
        return $url;
    }
} 