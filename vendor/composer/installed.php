<?php return array(
    'root' => array(
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'type' => 'projet',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => 'oclock/memory',
        'dev' => true,
    ),
    'versions' => array(
        'components/jquery' => array(
            'pretty_version' => '3.5.1',
            'version' => '3.5.1.0',
            'type' => 'component',
            'install_path' => __DIR__ . '/../components/jquery',
            'aliases' => array(),
            'reference' => 'b33e8f0f9a1cb2ae390cf05d766a900b53d2125b',
            'dev_requirement' => false,
        ),
        'leafo/lessphp' => array(
            'pretty_version' => 'v0.5.0',
            'version' => '0.5.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../leafo/lessphp',
            'aliases' => array(),
            'reference' => '0f5a7f5545d2bcf4e9fad9a228c8ad89cc9aa283',
            'dev_requirement' => false,
        ),
        'oclock/memory' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'type' => 'projet',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
        'twbs/bootstrap' => array(
            'pretty_version' => 'v5.0.2',
            'version' => '5.0.2.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../twbs/bootstrap',
            'aliases' => array(),
            'reference' => '688bce4fa695cc360a0d084e34f029b0c192b223',
            'dev_requirement' => false,
        ),
        'twitter/bootstrap' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => 'v5.0.2',
            ),
        ),
    ),
);
