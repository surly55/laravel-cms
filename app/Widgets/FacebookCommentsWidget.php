<?php

namespace App\Widgets;

class FacebookCommentsWidget
{
  const ID = 'image-widget';
  const NAME = '6. Image widget';

    protected $configDefaults = [
        'color_scheme' => 'light',
        'num_posts' => 10,
        'order_by' => 'social',
        'width' => 550,
        'width_type' => 'px',
    ];

    protected $colorSchemes = [ 'light' => 'Light', 'dark' => 'Dark' ];

    protected $orderBy = [ 'social' => 'Social', 'reverse_time' => 'Reverse time', 'time' => 'Time' ];

    protected $widthType = [ 'px' => 'Pixels (px)', '%' => 'Percentage (%)' ];

    public function configure(array $config = null)
    {
        if($config !== null) {
            $config = array_merge($this->configDefaults, $config);
        } else {
            $config = $this->configDefaults;
        }

        return [
            'form' => view('widget.facebook-comments.configure', [ 'config' => $config, 'colorSchemes' => $this->colorSchemes, 'orderBy' => $this->orderBy, 'widthType' => $this->widthType ])->render(),
        ];
    }
}
