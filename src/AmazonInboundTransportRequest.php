<?php

namespace Sonnenglas\AmazonMws;

use Sonnenglas\AmazonMws\DataType\PartneredLtlDataInput;
use Sonnenglas\AmazonMws\DataType\PartneredSmallParcelPackageInput;

class AmazonInboundTransportRequest extends AmazonInboundCore
{
  private $response;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );
  }

  public function setShipmentId( string $shipmentId )
  {
    $this->options['ShipmentId'] = $shipmentId;
  }

  /**
   * EstimateTransportRequest
   *
   * @return bool
   */
  public function estimate()
  {
    $this->options['Action'] = 'EstimateTransportRequest';

    return $this->send();
  }

  /**
   * ConfirmTransportRequest
   *
   * @return bool
   */
  public function confirm()
  {
    $this->options['Action'] = 'ConfirmTransportRequest';

    return $this->send();
  }

  /**
   * VoidTransportRequest
   *
   * @return bool
   */
  public function void()
  {
    $this->options['Action'] = 'VoidTransportRequest';

    return $this->send();
  }

  private function send()
  {
    if ( empty( $this->options['ShipmentId'] ) )
    {
      throw new \InvalidArgumentException( 'ShipmentId is required.' );
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