<?php

namespace Sonnenglas\AmazonMws\Datatypes;

class Address
{
  private $options = [];
  /**
   * Required attributes, the default is not set yet.
   *
   * @var array
   */
  private $requiredFields = [
    'Name'         => false,
    'AddressLine1' => false,
    'City'         => false,
    'CountryCode'  => false,
  ];

  public function setName( string $name )
  {
    $this->options['Name'] = substr( $name, 0, 50 );

    $this->requiredFields['Name'] = true;
  }

  public function setAddressLine1( string $addressLine1 )
  {
    $this->options['AddressLine1'] = substr( $addressLine1, 0, 180 );

    $this->requiredFields['AddressLine1'] = true;
  }

  public function setAddressLine2( string $addressLine2 )
  {
    $this->options['AddressLine2'] = substr( $addressLine2, 0, 60 );
  }

  public function setCity( string $city )
  {
    $this->options['City'] = substr( $city, 0, 30 );

    $this->requiredFields['City'] = true;
  }

  public function setDistrictOrCounty( string $districtOrCounty )
  {
    $this->options['DistrictOrCounty'] = substr( $districtOrCounty, 0, 25 );
  }

  public function setStateOrProvinceCode( string $stateOrProvinceCode )
  {
    $this->options['StateOrProvinceCode'] = substr( $stateOrProvinceCode, 0, 2 );
  }

  public function setCountryCode( string $countryCode )
  {
    if ( strlen( $countryCode ) != 2 )
    {
      throw new \InvalidArgumentException( 'CountryCode must be a two-character country code.' );
    }

    $this->options['CountryCode'] = $countryCode;

    $this->requiredFields['CountryCode'] = true;
  }

  public function setPostalCode( string $postalCode )
  {
    $this->options['PostalCode'] = substr( $postalCode, 0, 30 );
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
      throw new \InvalidArgumentException( 'Address missing requireds attributes' );
    }

    return $this->options;
  }
}