file="$1";
if [ ! -n $file ];
then
	echo "please give me the icon's filename, example: ./icon_creator.sh icon.png";
else
	if [ -e "$file" ]; 
	then
		if [ ! -d ios ]; then mkdir ios; fi
		if [ ! -d ios/watch ]; then mkdir ios/watch; fi
    	convert $file -resize 40x40 ios/Icon-40.png;
		convert $file -resize 80x80 ios/Icon-40@2x.png;
		convert $file -resize 120x120 ios/Icon-60@2x.png;
		convert $file -resize 180x180 ios/Icon-60@3x.png;
		convert $file -resize 76x76 ios/Icon-76.png;
		convert $file -resize 152x152 ios/Icon-76@2x.png;
		convert $file -resize 29x29 ios/Icon-Small.png;
		convert $file -resize 58x58 ios/Icon-Small@2x.png;
		convert $file -resize 87x87 ios/Icon-Small@3x.png;
		convert $file -resize 48x48 ios/watch/Icon-24.png;
		convert $file -resize 55x55 ios/watch/Icon-27-5.png;
		convert $file -resize 88x88 ios/watch/Icon-44.png;
		convert $file -resize 172x172 ios/watch/Icon-86.png;
		convert $file -resize 196x196 ios/watch/Icon-98.png;
		if [ ! -d android ]; then mkdir android; fi
		if [ ! -d android/drawable-ldpi ]; then mkdir android/drawable-ldpi; fi
		if [ ! -d android/drawable-mdpi ]; then mkdir android/drawable-mdpi; fi
		if [ ! -d android/drawable-hdpi ]; then mkdir android/drawable-hdpi; fi
		if [ ! -d android/drawable-xdpi ]; then mkdir android/drawable-xdpi; fi
		if [ ! -d android/drawable-xxdpi ]; then mkdir android/drawable-xxdpi; fi
		if [ ! -d android/drawable-xxxdpi ]; then mkdir android/drawable-xxxdpi; fi
		convert $file -resize 36x36 android/drawable-ldpi/ic_launcher.png;
		convert $file -resize 48x48 android/drawable-mdpi/ic_launcher.png;
		convert $file -resize 72x72 android/drawable-hdpi/ic_launcher.png;
		convert $file -resize 96x96 android/drawable-xdpi/ic_launcher.png;
		convert $file -resize 144x144 android/drawable-xxdpi/ic_launcher.png;
		convert $file -resize 192x192 android/drawable-xxxdpi/ic_launcher.png;

		echo "All icon has generated in folder android and ios.";
    else
    	echo "File not found!";
	fi
fi
