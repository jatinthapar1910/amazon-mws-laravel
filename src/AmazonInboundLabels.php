<?php

namespace Sonnenglas\AmazonMws;

use Exception;
use InvalidArgumentException;

class AmazonInboundLabels extends AmazonInboundCore
{
  private $response;

  public function __construct( $s, $mock = false, $m = null )
  {
    parent::__construct( $s, $mock, $m );
    include( $this->env );
  }

  /**
   * Remove PackageLabelsToPrint members from options
   */
  public function resetPackageLabels()
  {
    foreach ( $this->options as $option => $value )
    {
      if ( preg_match( "#PackageLabelsToPrint#", $option ) )
      {
        unset( $this->options[ $option ] );
      }
    }
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
   * Set NumberOfPackages
   *
   * @param int $numberOfPackages
   */
  public function setNumberOfPackages( int $numberOfPackages )
  {
    $this->options['NumberOfPackages'] = $numberOfPackages;
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
   * Set Number Of Pallets
   *
   * @param int $numberOfPallets
   */
  public function setNumberOfPallets( int $numberOfPallets )
  {
    $this->options['NumberOfPallets'] = $numberOfPallets;
  }

  /**
   * send GetUniquePackageLabels request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function getPackageLabels()
  {
    /**
     * Check required options
     */
    if ( empty( $this->options['PageType'] ) or empty( $this->options['NumberOfPackages'] ) )
    {
      throw new InvalidArgumentException( 'The PageType and NumberOfPackages attributes are required' );
    }

    unset( $this->options['NumberOfPallets'] );
    $this->resetPackageLabels();

    $this->options['Action'] = 'GetPackageLabels';

    return $this->send();
  }

  /**
   * send GetUniquePackageLabels request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function getUniquePackageLabels()
  {
    /**
     * Check required options
     */
    if ( empty( $this->options['PageType'] ) or empty( $this->options['PackageLabelsToPrint.member.1'] ) )
    {
      throw new InvalidArgumentException( 'The PageType and packages(cartons) attributes are required' );
    }

    unset( $this->options['NumberOfPackages'] );
    unset( $this->options['NumberOfPallets'] );

    $this->options['Action'] = 'GetUniquePackageLabels';

    return $this->send();
  }

  /**
   * send GetUniquePackageLabels request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function getPalletLabels()
  {
    /**
     * Check required options
     */
    if ( empty( $this->options['PageType'] ) or empty( $this->options['NumberOfPallets'] ) )
    {
      throw new InvalidArgumentException( 'The NumberOfPallets and PageType attributes are required' );
    }

    unset( $this->options['NumberOfPackages'] );
    $this->resetPackageLabels();

    $this->options['Action'] = 'GetPalletLabels';

    return $this->send();
  }

  /**
   * send GetUniquePackageLabels request to amazon
   *
   * @return bool
   * @throws Exception
   */
  public function getBillOfLading()
  {
    unset( $this->options['PageType'] );
    unset( $this->options['NumberOfPackages'] );
    unset( $this->options['NumberOfPallets'] );
    $this->resetPackageLabels();

    $this->options['Action'] = 'GetBillOfLading';

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
    if ( empty( $this->options['ShipmentId'] ) )
    {
      throw new InvalidArgumentException( 'The shipmentId attribute is required' );
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