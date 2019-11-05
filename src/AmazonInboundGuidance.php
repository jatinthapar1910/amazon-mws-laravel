<?php

namespace Sonnenglas\AmazonMws;

use Config;
use Exception;
use InvalidArgumentException;

class AmazonInboundGuidance extends AmazonInboundCore
{
  private $response;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );

    $store = Config::get( 'amazon-mws.store' );

    if ( isset( $store[ $s ] ) && array_key_exists( 'marketplaceId', $store[ $s ] ) )
    {
      $this->options['MarketplaceId'] = $store[ $s ]['marketplaceId'];
    } else
    {
      $this->log( "Marketplace ID is missing", 'Urgent' );
    }
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
   * Set SellerSKUList
   *
   * @param array|string $idList
   * @param string $idType SellerSKU or ASIN
   */
  public function setIdList( $idList, string $idType )
  {
    if ( ! is_array( $idList ) )
    {
      $idList = [ $idList ];
    }

    $optionName = $idType == 'ASIN' ? 'ASINList.Id.' : 'SellerSKUList.Id.';

    foreach ( array_values( $idList ) as $index => $id )
    {
      $this->options[ $optionName . ( $index + 1 ) ] = $id;
    }
  }

  /**
   * send GetPrepInstructionsForSKU request to amazon
   *
   * @param string $idType SellerSKU or ASIN
   *
   * @return bool
   * @throws Exception
   */
  public function fetch( string $idType )
  {
    if ( $idType == 'ASIN' )
    {
      if ( empty( $this->options['ASINList.Id.1'] ) )
      {
        throw new InvalidArgumentException( 'The ASINList attribute is required' );
      }

      $this->resetSellerSKUList();
      $this->options['Action'] = 'GetInboundGuidanceForASIN';
    } else
    {
      if ( empty( $this->options['SellerSKUList.Id.1'] ) )
      {
        throw new InvalidArgumentException( 'The SellerSKUList attribute is required' );
      }

      $this->resetASINList();
      $this->options['Action'] = 'GetInboundGuidanceForSKU';
    }

    return $this->send();
  }

  /**
   * @return bool
   * @throws Exception
   */
  private function send()
  {
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
      return empty( $this->options['ASINList.Id.1'] ) ? $this->response['SKUInboundGuidanceList'] : $this->response['ASINInboundGuidanceList'];
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
      return empty( $this->options['ASINList.Id.1'] ) ? $this->response['InvalidSKUList'] : $this->response['InvalidASINList'];
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