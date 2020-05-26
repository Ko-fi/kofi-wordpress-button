<?php

namespace KofiTestExtensions;

use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;
use PaulGibbs\WordpressBehatExtension\Context\Traits;
use KofiTestExtensions\SideBarElement;

trait OptionsAPIAwareTrait
{
    use \PaulGibbs\WordpressBehatExtension\Context\Traits\BaseAwarenessTrait;

    /**
     * Check to see if an option still exists
     * 
     * @param string $option_name
     * 
     * @return bool True if the option doesn't exist
     */
    public function assertOptionDoesntExist( $option_name ) {

        $options_list = json_decode( $this->getDriver()->wpcli('option', 'list', [
            '--search="'.$option_name.'"','--format=json',
        ])['stdout'] );

        if( !empty( $options_list ) ) {
            throw new \UnexpectedValueException(sprintf('The option "%s" still exists', $option_name ));
        }

    }

}