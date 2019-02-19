<?php declare(strict_types=1);


namespace Unit\RemoteStorage;

use App\Infrastructure\Interfaces\IRemoteStorageClient;
use App\Modules\RemoteStorage\RemoteStorageService;
use Tests\TestCase;

final class ServiceTest extends TestCase
{
/*
    public function testRealDownload() {
        $service = app()->make(RemoteStorageService::class);
        var_dump($service->downloadRemoteFileByKey('/AWS SNS 2018-10-16 16-26-50.png'));
    }
*/

    public function testCanGetRootFiles() {
        $client = new class implements IRemoteStorageClient {
            public function downloadItem(string $remotePath, string $localPath): string
            {
                new \Exception('invalid method to test');

                return "";
            }

            public function getItemsList(): array
            {
                return [
                    '/2018-hyundai-i30-104421.pdf',
                    '/20181204101056_119.mp4',
                    '/AWS SNS 2018-10-16 16-26-50.png',
                    '/BA4CBF91-B02C-42F6-963E-A2D732AC9DB4.m4a',
                    '/CH341SER_MAC/ReadMe.pdf',
                    '/Gazer_F720_v3.2.3.12_323_ua.zip',
                    '/Gazer_F720_v3.2.3.12_323_ua/.DS_Store',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/no_upginfo',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/rootfs',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/rtl_hostapd.conf',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/rtl_hostapd_2G.conf',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/tmp/usr/bin/',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/tmp/usr/cfg/IMX323',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/uImage',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/uboot',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/update.sh',
                    '/Gazer_F720_v3.2.3.12_323_ua/update/version',
                    '/Gazer_F720_v3.2.3.12_323_ua/Інструкція по оновленню ПЗ F720.txt',
                    '/Linux-handbook-comands-A-Z-SEDICOMM-University.pdf',
                    '/Vysor-mac.zip',
                    '/js/app_128_1.js',
                    '/js/app_211_1.js',
                    '/laravel.log',
                    '/pgadmin4-3.6.dmg',
                    '/project836861/404.html',
                    '/project836861/css/tilda-animation-1.0.min.css',
                    '/project836861/css/tilda-blocks-2.12.css',
                    '/project836861/css/tilda-grid-3.0.min.css',
                    '/project836861/css/tilda-slds-1.4.min.css',
                    '/project836861/css/tilda-zoom-2.0.min.css',
                    '/project836861/files/page3534645body.html',
                    '/project836861/files/page3676091body.html',
                    '/project836861/htaccess',
                    '/project836861/images/tild3162-6436-4265-b161-643861303263__2artboard1copy5.png',
                    '/project836861/images/tild3266-6634-4364-a333-323864363030__-__resize__20x__backgr_white.png',
                    '/project836861/images/tild3266-6634-4364-a333-323864363030__backgr_white.png',
                    '/project836861/images/tild3332-3636-4239-a137-636533356636__-__empty__Classic_App_Store_sc.png',
                    '/project836861/images/tild3332-3636-4239-a137-636533356636__classic_app_store_sc.png',
                    '/project836861/images/tild3437-3934-4863-a539-396632323365__-__empty__Classic_App_Store_sc.png',
                    '/project836861/images/tild3437-3934-4863-a539-396632323365__classic_app_store_sc.png',
                    '/project836861/images/tild3833-6639-4432-b231-373763323635__-__empty__Classic_App_Store_sc.png',
                    '/project836861/images/tild3833-6639-4432-b231-373763323635__classic_app_store_sc.png',
                    '/project836861/images/tild6237-6534-4063-b965-646231363531__cl_icon_smooth.png',
                    '/project836861/images/tild6465-6530-4733-b132-333065376465__image_2.png',
                    '/project836861/images/tild6537-3032-4935-b938-623333363063__cl_icon_smooth.png',
                    '/project836861/images/tildacopy.png',
                    '/project836861/images/tildacopy_black.png',
                    '/project836861/images/tildafavicon.ico',
                    '/project836861/js/hammer.min.js',
                    '/project836861/js/jquery-1.10.2.min.js',
                    '/project836861/js/lazyload-1.3.min.js',
                    '/project836861/js/tilda-animation-1.0.min.js',
                    '/project836861/js/tilda-blocks-2.7.js',
                    '/project836861/js/tilda-scripts-2.8.min.js',
                    '/project836861/js/tilda-slds-1.4.min.js',
                    '/project836861/js/tilda-zoom-2.0.min.js',
                    '/project836861/page3534645.html',
                    '/project836861/page3676091.html',
                    '/project836861/readme.txt',
                    '/project836861/robots.txt',
                    '/project836861/sitemap.xml',
                    '/setup_hotline_miami_2.2.0.8.exe',
                    '/setup_race_the_sun_2.5.0.10.exe',
                    '/start.jnlp',
                    '/unetbootin-mac-661.dmg',
                    '/video/L_20181105133548_223_71.mp4',
                    '/video/L_20181107103459_300_17.mp4',
                    '/video/L_20181112072736_279_194.mp4',
                ];
            }
        };

        $service = new RemoteStorageService($client);

        $items = $service->getRootDirectoryFiles();

        $this->assertTrue(in_array('2018-hyundai-i30-104421.pdf', $items), 'Incorect root files');

    }

}