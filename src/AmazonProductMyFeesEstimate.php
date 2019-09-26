<?php

namespace Sonnenglas\AmazonMws;

use InvalidArgumentException;
use Sonnenglas\AmazonMws\DataType\FeesEstimateRequest;

class AmazonProductMyFeesEstimate extends AmazonCore
{
  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );

    $productVersion = '2011-10-01';

    $this->urlbranch = 'Products/' . $productVersion;

    $this->options['Action']  = 'GetMyFeesEstimate';
    $this->options['Version'] = $productVersion;
  }

  public function setProducts( array $feesEstimateRequest )
  {
    foreach ( $feesEstimateRequest as $index => $product )
    {
      $productIndex = $index + 1;

      if ( ! $product instanceof FeesEstimateRequest )
      {
        throw new InvalidArgumentException( 'The product list must-have items of FeesEstimateRequest datatype.s' );
      }

      foreach ( $product->toArray() as $key => $value )
      {
        $this->options[ 'FeesEstimateRequestList.FeesEstimateRequest.' . $productIndex . '.' . $key ] = $value;
      }

      if ( empty( $this->options[ 'FeesEstimateRequestList.FeesEstimateRequest.' . $productIndex . '.MarketplaceId' ] ) )
      {
        $this->options[ 'FeesEstimateRequestList.FeesEstimateRequest.' . $productIndex . '.MarketplaceId' ] = $this->getMarketplaceId();
      }
    }
  }

  public function fetchMyFeesEstimate()
  {
    if ( ! array_key_exists( 'FeesEstimateRequestList.FeesEstimateRequest.1.IdValue', $this->options ) )
    {
      throw new InvalidArgumentException( 'You must set at least one product' );
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