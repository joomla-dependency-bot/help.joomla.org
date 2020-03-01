<?php
/**
 * Joomla! Help Site
 *
 * @copyright  Copyright (C) 2016 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 * Portions of this code are derived from the previous help screen proxy component,
 * please see https://github.com/joomla-projects/help-proxy for attribution
 */

namespace Joomla\Help\Service;

use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Registry\Registry;

/**
 * Configuration service provider
 */
class ConfigProvider implements ServiceProviderInterface
{
	/**
	 * Path to the config file.
	 *
	 * @var  string
	 */
	private $file;

	/**
	 * Constructor.
	 *
	 * @param   string  $file  Path to the config file.
	 *
	 * @throws  \RuntimeException
	 */
	public function __construct($file)
	{
		$this->file = $file;
	}

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 */
	public function register(Container $container)
	{
		$container->share(
			'config',
			function (): Registry
			{
				// Verify the configuration exists and is readable.
				if (!is_readable($this->file))
				{
					throw new \RuntimeException('Configuration file does not exist or is unreadable.');
				}

				return (new Registry)->loadFile($this->file);
			}
		);
	}
}
