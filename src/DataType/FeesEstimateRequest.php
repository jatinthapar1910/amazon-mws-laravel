<?php

namespace Sonnenglas\AmazonMws\DataType;

use InvalidArgumentException;

class FeesEstimateRequest
{
  private $options = [];
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'MarketplaceId'     => false,
    'IdType'            => false,
    'IdValue'           => false,
    'ListingPrice'      => false,
    'Identifier'        => false,
    'IsAmazonFulfilled' => false,
  ];

  public function setMarketplaceId( string $marketplaceId )
  {
    $this->options['MarketplaceId'] = $marketplaceId;

    $this->requiredFields['MarketplaceId'] = true;
  }

  public function setIdType( string $idType )
  {
    $this->options['IdType'] = $idType;

    $this->requiredFields['IdType'] = true;
  }

  public function setIdValue( string $idValue )
  {
    $this->options['IdValue'] = $idValue;

    $this->requiredFields['IdValue'] = true;
  }

  public function setListingPrice( float $listingPrice, string $currencyCode = 'USD' )
  {
    $this->options['PriceToEstimateFees.ListingPrice.Amount']       = $listingPrice;
    $this->options['PriceToEstimateFees.ListingPrice.CurrencyCode'] = $currencyCode;

    $this->requiredFields['ListingPrice'] = true;
  }

  public function setShipping( float $shipping, string $currencyCode = 'USD' )
  {
    $this->options['PriceToEstimateFees.Shipping.Amount']       = $shipping;
    $this->options['PriceToEstimateFees.Shipping.CurrencyCode'] = $currencyCode;
  }

  public function setPoints( int $pointsNumber )
  {
    $this->options['PriceToEstimateFees.Points.PointsNumber'] = $pointsNumber;
  }

  public function setIdentifier( string $identifier )
  {
    $this->options['Identifier'] = $identifier;

    $this->requiredFields['Identifier'] = true;
  }

  public function setIsAmazonFulfilled( bool $isAmazonFulfilled )
  {
    $this->options['IsAmazonFulfilled'] = $isAmazonFulfilled;

    $this->requiredFields['IsAmazonFulfilled'] = true;
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
      throw new InvalidArgumentException( 'FeesEstimateRequest missing required attributes' );
    }

    return $this->options;
  }
}