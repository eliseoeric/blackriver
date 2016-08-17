<?php
namespace Blackriver;

use ArrayAccess;
use Closure;
use ReflectionClass;

class Container implements ArrayAccess {

	protected $contents;

	public function __construct()
	{
		$this->contents = array();
	}

	/**
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 *
	 * @param mixed $offset
	 * An offset to check for.
	 * @return boolean true on success or false on failure.
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists( $offset )
	{
		return isset( $this->contents[ $offset ] );
	}

	/**
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 *
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 *
	 * @return mixed Can return all value types.
	 * @since 5.0.0
	 */
	public function offsetGet( $offset )
	{

		//todo need to set this up to use the shared() method
		if( is_callable( $this->contents['concrete'][ $offset ] ) )
		{
			return call_user_func( $this->contents[ $offset ], $this );
		}
		return isset( $this->contents[ $offset ] ) ? $this->contents[ $offset ] : null;
	}

	/**
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 *
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 *
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetSet( $offset, $value )
	{
		$this->contents[ $offset ] = $value;
	}

	/**
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 *
	 * @param mixed $offset
	 * The offset to unset.
	 *
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset( $offset )
	{
		unset( $this->contents[ $offset ] );
	}

	public function singleton( $abstract, $concrete = null )
	{
		$this->bind( $abstract, $concrete, true );
	}

	public function bind( $abstract, $concrete = null, $shared = false )
	{
		$this->contents[$abstract] = compact('concrete', 'shared');

	}

	public function share( Closure $closure )
	{
		return function ($container) use ($closure) {
			static $object;

			if( is_null( $object ))
			{
				$object = $closure($container);
			}

			return $object;
		};
	}

	/**
	 * test
	 */
	public function boot()
	{
		foreach ( $this->contents as $key => $content )
		{
			//loop through the contents
			if( is_callable( $content ) )
			{
				$content = $this[ $key ];
			}
			if( is_object( $content ) )
			{
				$reflection = new ReflectionClass( $content );
				if( $reflection->hasMethod( 'boot' ) )
				{
					$content->boot(); // Call run method on object
				}
			}
		}
	}
}