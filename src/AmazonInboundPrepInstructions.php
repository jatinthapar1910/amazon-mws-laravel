<?php

namespace Sonnenglas\AmazonMws;

use Exception;
use InvalidArgumentException;

class AmazonInboundPrepInstructions extends AmazonInboundCore
{
  private $response;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );
  }

  /**
   * Remove SellerSKUList members from options
   */
  public function resetSellerSKUList()
  {
    foreach ( $this->options as $option => $value )
    {
      if ( preg_match( "#SellerSKUList#", $option ) )
      {
        unset( $this->options[ $option ] );
      }
    }
  }

  /**
   * Remove ASINList members from options
   */
  public function resetASINList()
  {
    foreach ( $this->options as $option => $value )
    {
      if ( preg_match( "#ASINList#", $option ) )
      {
        unset( $this->options[ $option ] );
      }
    }
  }

  /**
   * Set ShipToCountryCode
   *
   * @param string $shipToCountryCode
   */
  public function setShipToCountryCode( string $shipToCountryCode )
  {
    if ( strlen( $shipToCountryCode ) != 2 )
    {
      throw new InvalidArgumentException( 'The ShipToCountryCode value must be a two-character country code, in ISO 3166-1 alpha-2 format.' );
    }

    $this->options['ShipToCountryCode'] = $shipToCountryCode;
  }

  /**
   * Set SellerSKUList
   *
   * @param array|string $sellerSKUList
   */
  public function setSellerSKUList( $sellerSKUList )
  {
    if ( ! is_array( $sellerSKUList ) )
    {
      $sellerSKUList = [ $sellerSKUList ];
    }

    foreach ( array_values( $sellerSKUList ) as $index => $sku )
    {
      $this->options[ 'SellerSKUList.Id.' . ( $index + 1 ) ] = $sku;
    }
  }

  /**
   * Set ASINList
   *
   * @param array|string $asinList
   */
  public function setASINList( $asinList )
  {
    if ( ! is_array( $asinList ) )
    {
      $asinList = [ $asinList ];
    }

    foreach ( array_values( $asinList ) as $index => $asin )
    {
      $this->options[ 'ASINList.Id.' . ( $index + 1 ) ] = $asin;
    }
  }

  /**
   * send GetPrepInstructionsForSKU request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function getForSKU()
  {
    /**
     * Check required options
     */
    if ( empty( $this->options['SellerSKUList.Id.1'] ) )
    {
      throw new InvalidArgumentException( 'The SellerSKUList attribute is required' );
    }

    $this->resetASINList();

    $this->options['Action'] = 'GetPrepInstructionsForSKU';

    return $this->send();
  }

  /**
   * send GetPrepInstructionsForSKU request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function getForASIN()
  {
    /**
     * Check required options
     */
    if ( empty( $this->options['ASINList.Id.1'] ) )
    {
      throw new InvalidArgumentException( 'The ASINList attribute is required' );
    }

    $this->resetSellerSKUList();

    $this->options['Action'] = 'GetPrepInstructionsForASIN';

    return $this->send();
  }

  /**
   * @return bool
   * @throws Exception
   */
  private function send()
  {
    /**
     * Check required options
     */
    if ( empty( $this->options['ShipToCountryCode'] ) )
    {
      throw new InvalidArgumentException( 'The ShipToCountryCode attribute is required' );
    }

    $url = $this->urlbase . $this->urlbranch;

    $query = $this->genQuery();

    $path = $this->options['Action'] . 'Result';

    $response = $this->sendRequest( $url, [ 'Post' => $query ] );

    if ( ! $this->checkResponse( $response ) )
    {
      return false;
    }

    $xml = simplexml_load_string( $response['body'] )->$path;

    $this->parseXML( $xml );

    return true;
  }

  protected function parseXML( $xml )
  {
    $this->response = json_decode( json_encode( $xml ), true );
  }

  /**
   * Get PrepInstructionsList
   *
   * @return string|bool
   */
  public function getPrepInstructionsList()
  {
    if ( isset( $this->response ) )
    {
      return empty( 'ASINList.Id.1' ) ? $this->response['SKUPrepInstructionsList'] : $this->response['ASINPrepInstructionsList'];
    }

    return false;
  }

  /**
   * Get InvalidList
   *
   * @return string|bool
   */
  public function getInvalidList()
  {
    if ( isset( $this->response ) )
    {
      return empty( 'ASINList.Id.1' ) ? $this->response['InvalidSKUList'] : $this->response['InvalidASINList'];
    }

    return false;
  }

  public function getResponse()
  {
    if ( isset( $this->response ) )
    {
      return $this->response;
    } else
    {
      return false;
    }
  }
}