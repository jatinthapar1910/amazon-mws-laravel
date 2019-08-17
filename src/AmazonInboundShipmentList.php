<?php

namespace Sonnenglas\AmazonMws;

use Exception;
use InvalidArgumentException;

class AmazonInboundShipmentList extends AmazonInboundCore
{
  private $response;
  private $setRequired = false;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );

    $this->options['Action'] = 'ListInboundShipments';
  }

  public function setShipmentStatusList( $shipmentStatusList )
  {
    if ( ! is_array( $shipmentStatusList ) )
    {
      $shipmentStatusList = [ $shipmentStatusList ];
    }

    foreach ( $shipmentStatusList as $index => $shipmentStatus )
    {
      $this->options[ 'ShipmentStatusList.member.' . ( $index + 1 ) ] = $shipmentStatus;

      $this->setRequired = true;
    }
  }

  public function setShipmentIdList( $shipmentIdList )
  {
    if ( ! is_array( $shipmentIdList ) )
    {
      $shipmentIdList = [ $shipmentIdList ];
    }

    foreach ( $shipmentIdList as $index => $shipmentId )
    {
      $this->options[ 'ShipmentIdList.member.' . ( $index + 1 ) ] = $shipmentId;

      $this->setRequired = true;
    }
  }

  /**
   * @param null $after
   * @param null $before
   *
   * @return bool
   * @throws Exception
   */
  public function setLastUpdated( $after = null, $before = null )
  {
    if ( $before )
    {
      $this->options['LastUpdatedBefore'] = $this->genTime( $before );
    }

    if ( $after )
    {
      $this->options['LastUpdatedAfter'] = $this->genTime( $after );
    }
  }

  /**
   * send ListInboundShipments request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function fetchShipments()
  {
    if ( ! array_key_exists( 'LastUpdatedAfter', $this->options ) &&
         ! array_key_exists( 'LastUpdatedBefore', $this->options ) )
    {
      throw new InvalidArgumentException( 'Must specified LastUpdated' );
    }

    if ( ! $this->setRequired )
    {
      throw new InvalidArgumentException( 'Must specified ShipmentStatusList or ShipmentIdList' );
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