<?php

namespace Sonnenglas\AmazonMws;

use Exception;
use InvalidArgumentException;

class AmazonInboundUniquePackageLabels extends AmazonInboundCore
{
  private $response;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );

    $this->options['Action'] = 'GetUniquePackageLabels';
  }

  /**
   * Set ShipmentId
   *
   * @param string $shipmentId
   */
  public function setShipmentId( string $shipmentId )
  {
    $this->options['ShipmentId'] = $shipmentId;
  }

  /**
   * Set Page Type
   *
   * @param string $pageType
   */
  public function setPageType( string $pageType )
  {
    /**
     * Check unit value is valid.
     */
    if ( ! in_array( $pageType, Enum::PAGE_TYPES ) )
    {
      throw new InvalidArgumentException( 'Invalid PageType. possible: ' . implode( ',', Enum::PAGE_TYPES ) );
    }

    $this->options['PageType'] = $pageType;
  }

  /**
   * Set carton ids to print
   *
   * @param array|string $cartonIds
   */
  public function setPackageLabelsToPrint( $cartonIds )
  {
    if ( ! is_array( $cartonIds ) )
    {
      $cartonIds = [ $cartonIds ];
    }

    foreach ( $cartonIds as $index => $cartonId )
    {
      $this->options[ 'PackageLabelsToPrint.member.' . ( $index + 1 ) ] = $cartonId;
    }
  }

  /**
   * send GetUniquePackageLabels request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function get()
  {
    $requiredKeys = [
      'ShipmentId',
      'PageType',
      'PackageLabelsToPrint.member.1',
    ];

    /**
     * Check required options
     */
    $missingKeys = array_diff( $requiredKeys, array_keys( $this->options ) );
    if ( $missingKeys )
    {
      throw new InvalidArgumentException( 'Missing required values: ' . implode( ',', $missingKeys ) );
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
   * Amazon compresses PDF document data before returning it as a Base64-encoded string.
   * To obtain the actual PDF document, you must decode the Base64-encoded string,
   * save it as a binary file with a “.zip” extension, and then extract the PDF file from the ZIP file.
   *
   * @return string|bool
   */
  public function getPdfDocument()
  {
    if ( isset( $this->response ) )
    {
      return $this->response['TransportDocument']['PdfDocument'];
    }

    return false;
  }

  /**
   * These operations also return a Base64-encoded MD5 hash to validate the document data.
   *
   * @return string|bool
   */
  public function getChecksum()
  {
    if ( isset( $this->response ) )
    {
      return $this->response['TransportDocument']['Checksum'];
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