<?php

$data = [
  "menu" => [
    "id" => "main_menu",
    "data" => [
      [
        "href" => "./",
        "title" => "HOME"
      ],
      [
        "href" => "#",
        "title" => "MEN",
        "submenu" => [
          "id" => "sub_men",
          "data" => [
            [
              "href" => "./product",
              "title" => "Sweaters"
            ],
            [
              "href" => "./product",
              "title" => "Coats"
            ],
            [
              "href" => "./product",
              "title" => "Jampers"
            ],
            [
              "href" => "./product",
              "title" => "Shirts"
            ],
          ]
        ]
      ],
      [
        "href" => "#",
        "title" => "WOMEN",
        "submenu" => [
          "id" => "women",
          "data" => [
            [
              "href" => "./product",
              "title" => "Sweaters"
            ],
            [
              "href" => "./product",
              "title" => "Coats"
            ],
            [
              "href" => "./product",
              "title" => "Jampers"
            ],
            [
              "href" => "./product",
              "title" => "Shirts"
            ],
          ]
        ]
      ],
      [
        "href" => "#",
        "title" => "KIDS",
        "submenu" => [
          "id" => "sub_kids",
          "data" => [
            [
              "href" => "./product",
              "title" => "Sweaters"
            ],
            [
              "href" => "./product",
              "title" => "Coats"
            ],
            [
              "href" => "./product",
              "title" => "Jampers"
            ],
            [
              "href" => "./product",
              "title" => "Shirts"
            ],
          ]
        ]
      ],
      [
        "href" => "#",
        "title" => "ACCESSORIES",
        "submenu" => [
          "id" => "sub_access",
          "data" => [
            [
              "href" => "./product",
              "title" => "Sweaters"
            ],
            [
              "href" => "./product",
              "title" => "Coats"
            ],
            [
              "href" => "./product",
              "title" => "Jampers"
            ],
            [
              "href" => "./product",
              "title" => "Shirts"
            ],
          ]
        ]
      ],
      [
        "href" => "./product",
        "title" => "FEATURED"
      ],
      [
        "href" => "./product",
        "title" => "HOT DEALS"
      ],
      [
        "href" => "./checkout",
        "title" => "REVIEWS"
      ],
    ]
  ]
];
echo json_encode($data);

?>