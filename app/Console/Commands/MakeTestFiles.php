<?php

namespace App\Console\Commands;

use Faker\Factory;
use Illuminate\Console\Command;

class MakeTestFiles extends Command
{

    private $faker;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MakeTestFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Factory $fakerFactory)
    {
        $this->faker = $fakerFactory->create();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '4G');
        $profiles = $this->getProfileKeys(100000);
        foreach ($profiles as $uuid => $email) {
            //$this->generateProfile($uuid,$email);
            echo json_encode($this->generateProfile($uuid,$email))."\n";
        }
    }

    private function getProfileKeys($num) {
        $emails = [];
        $uuid = [];
        for($i=0; $i<$num*1.2; $i++) {
            $emails[$this->faker->email] = null;
            $uuid[$this->faker->uuid] = null;
        }
        $emails = array_slice($emails, 0, $num);
        $uuid = array_slice($uuid, 0, $num);

        return array_combine(array_keys($uuid), array_keys($emails));
    }

    private function generateProfile($profileId, $email) {
        $data = [
            'profile_id' => $profileId,
            'email' => $email,
            'clicks' => $this->generateClicks(),
            'custom_vars' => [
                'geo' => $this->generateGeo(),
                'current_subscriptions' => $this->generateSubs(),
            ],
        ];

        return $data;
    }

    private function generateClicks() {
        $campaignsID = rand(100,1000000);
        $clicksNum = rand(50, 100);
        $clicks = [];
        for($i=0; $i < $clicksNum; $i++) {
            $url = $this->faker->url;
            $campaignsID += rand(1,9);
            $time = $this->faker->dateTimeBetween('-5 years');
            $click = [
                'campaign_id' => $campaignsID,
                'url' => $url,
                'time' => $time,
            ];

            $clicks[$url] = $click;
        }

        shuffle($clicks);
        return array_values($clicks);
    }

    private function generateGeo() {
        $tree = $this->getGeoTree();
        $treeData = $this->generateGeoLeaf($tree);

        return $treeData;
    }

    private function generateGeoLeaf($leaf, ?int &$parentViews = null) {
        $views = 0;
        if (!empty($leaf['children'])) {
            $childrenData = [];
            $children = $leaf['children'];
            $countChildren = count($children);
            $maxNumOfChildren = $countChildren; //($countChildren < 5) ? $countChildren : 5;
            shuffle($children);
            $children = array_slice($children, 0, rand(0,$maxNumOfChildren));

            foreach ($children as $elem) {
                if (is_array($elem)) {
                    $childData = $this->generateGeoLeaf($elem,$views);
                    if (!empty($childData)) {
                        $childrenData[] = $childData;
                    }
                } else {
                    $childViews = rand(1,100);
                    $views += $childViews;
                    $childrenData[] = [
                        'name' => $elem,
                        'view_count' => $childViews,
                    ];
                }
            }
        }

        if ($views === 0) return [];

        $parentViews += $views;
        $data = [
            'name' => $leaf['name'],
            'view_count' => $views,
        ];
        if (!empty($childrenData)) {
            $data[$leaf['childrenFieldName']] = $childrenData;
        }

        return $data;
    }


    private function generateSubs() {
        $data = [];
        $subs = $this->getSubs();
        $keys = array_rand($subs,rand(2,5));
        foreach ($keys as $subKey) {
            $data[] = [
                'id' => $subKey,
                'name' => $subs[$subKey],
                'time' => $this->faker->dateTimeBetween('-5 years'),
            ];
        }

        return $data;
    }

    private function getSubs() {
        return [
            1 => 'HI SUB',
            2 => 'IL SUB',
            3 => 'CO SUB',
            4 => 'MA SUB',
            5 => 'NV SUB',
            6 => 'NC SUB',
            7 => 'TX SUB',
            8 => 'CA SUB',
        ];
    }

    private function getGeoTree() {
        $tree = [
                    'name' => 'US',
                    'childrenFieldName' => 'states',
                    'children' => [
                        [
                            'name' => 'California',
                            'childrenFieldName' => 'cities',
                            'children' => [
                                'Los Angeles',
                                'San Diego',
                                'San Jose',
                                'San Francisco',
                            ],
                        ],
                        [
                            'name' => 'Florida',
                            'childrenFieldName' => 'cities',
                            'children' => [
                                'Miami',
                                'Orlando',
                                'Palm Beach',
                            ],
                        ],
                        [
                            'name' => 'Texas',
                            'childrenFieldName' => 'cities',
                            'children' => [
                                'Houston',
                                'Dallas',
                                'El Paso',
                                'San Antonio'
                            ],
                        ],
                        [
                            'name' => 'New York',
                            'childrenFieldName' => 'cities',
                            'children' => [
                                'New York City',
                                'Buffalo',
                            ],
                        ],
                        [
                            'name' => 'Arizona',
                            'childrenFieldName' => 'cities',
                            'children' => [
                                'Phoenix',
                                'Tucson',
                                'Mesa'
                            ],
                        ],
                        [
                            'name' => 'Indiana',
                            'childrenFieldName' => 'cities',
                            'children' => [
                               'Indianapolis',
                               'Fort Wayn'
                            ],
                        ],

                    ]
                ];

        return $tree;
    }

}
