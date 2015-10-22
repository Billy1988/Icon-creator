<?php
include('SimpleImage.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["icon"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["icon"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["icon"]["tmp_name"], $target_file)) {
        echo "<br>The file ". basename( $_FILES["icon"]["name"]). " has been uploaded.";

        $image = new SimpleImage();

		$neediOS = $_POST['ios'];
		$needAndroid = $_POST['android'];

		$ios = array('Icon-40.png'=>'40', 'Icon-40@2x.png'=>'80', 'Icon-60@2x.png'=>'120', 'Icon-60@3x.png'=>'180',
			'Icon-76.png'=>'76', 'Icon-76@2x.png'=>'152', 'Icon-Small.png'=>'29', 'Icon-Small@2x.png'=>'58', 'Icon-Small@3x.png'=>'87',
			'Icon-24.png'=>'48', 'Icon-27-5.png'=>'55','Icon-44.png'=>'88',
			'Icon-86.png'=>'172', 'Icon-98.png'=>'196');

		$android = array('drawable-hdpi' => '72', 'drawable-ldpi' => '36', 'drawable-mdpi' => '48', 
			'drawable-xdpi' => '96', 'drawable-xxdpi' => '144', 'drawable-xxxdpi' => '192');

		$ios_path = 'outputs/ios/';
		$android_path = 'outputs/android/';

		if ($neediOS == 'yes') {
			if (!file_exists($ios_path)) {
				mkdir($ios_path, 0777, true);
			}
			foreach ($ios as $key => $value) {
				$image->load($target_file);
		    	$image->resize($value, $value);
		    	$image->save($ios_path . $key, IMAGETYPE_PNG);
			}
		}

		if ($needAndroid == 'yes') {
			foreach ($android as $key => $value) {
				if (!file_exists($android_path . $key)) {
					mkdir($android_path . $key);
				}
				$image->load($target_file);
		    	$image->resize($value, $value);
		    	$image->save($android_path . $key . '/ic_launcher.png', IMAGETYPE_PNG);
			}
		}

		// Get real path for our folder
		$rootPath = realpath('outputs');

		// Initialize archive object
		$zip = new ZipArchive();
		$zip->open('icons.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

		// Initialize empty "delete list"
		$filesToDelete = array();

		// Create recursive directory iterator
		/** @var SplFileInfo[] $files */
		$files = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator($rootPath),
		    RecursiveIteratorIterator::LEAVES_ONLY
		);

		foreach ($files as $name => $file)
		{
		    // Skip directories (they would be added automatically)
		    if (!$file->isDir())
		    {
		        // Get real and relative path for current file
		        $filePath = $file->getRealPath();
		        $relativePath = substr($filePath, strlen($rootPath) + 1);

		        // Add current file to archive
		        $zip->addFile($filePath, $relativePath);

		        // Add current file to "delete list"
		        // delete it later cause ZipArchive create archive only after calling close function and ZipArchive lock files until archive created)
		        if ($file->getFilename() != 'important.txt')
		        {
		            $filesToDelete[] = $filePath;
		        }
		    }
		}

		// Zip archive will be created only after closing object
		$zip->close();

		// Delete all files from "delete list"
		foreach ($filesToDelete as $file)
		{
		    unlink($file);
		}

		echo "<br><br><a href=\"icons.zip\">download the icons</a>";

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>