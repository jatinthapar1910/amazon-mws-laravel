<?php

namespace Sonnenglas\AmazonMws\DataType;

use Sonnenglas\AmazonMws\Enum;

class PrepDetails
{
  private $options = [ 'PrepInstruction' => 'NONE' ];
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'PrepOwner' => false,
  ];

  /**
   * Set PrepInstruction
   *
   * @param string $instruction
   */
  public function setPrepInstruction( string $instruction )
  {
    $this->options['PrepInstruction'] = $instruction;
  }

  /**
   * Set PrepOwner
   *
   * @param string $owner
   */
  public function setPrepOwner( string $owner )
  {
    if ( ! in_array( $owner, Enum::PREP_OWNERS ) )
    {
      throw new \InvalidArgumentException( 'Invalid value of PrepOwner. possible: ' . implode( ',', Enum::PREP_OWNERS ) );
    }

    $this->options['PrepOwner'] = $owner;

    $this->requiredFields['PrepOwner'] = true;
  }

  /**
   * Check required attributes and return options.
   *
   * @return array
   */
  public function toArray()
  {
    if ( array_sum( $this->requiredFields ) < count( $this->requiredFields ) )
    {
      throw new \InvalidArgumentException( 'Pallet missing required attributes' );
    }

    return $this->options;
  }
}