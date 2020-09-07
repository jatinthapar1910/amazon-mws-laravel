<?php

namespace Sonnenglas\AmazonMws;

interface Enum
{
  /**
   * Amazon Marketplaces
   */
  const MARKETPLACE_US     = 'ATVPDKIKX0DER';
  const MARKETPLACE_CANADA = 'A2EUQ1WTGCTBG2';
  const MARKETPLACE_UK     = 'A1F83G8C2ARO7P';
  const MARKETPLACES       = [
    self::MARKETPLACE_US     => 'US',
    self::MARKETPLACE_CANADA => 'Canada',
    self::MARKETPLACE_UK     => 'UK',
  ];

  /**
   * Amazon Order Status
   */
  const ORDER_STATUS_PENDING           = 'Pending'; // The order has been placed but payment has not been authorized. The order is not ready for shipment.
  const ORDER_STATUS_UNSHIPPED         = 'Unshipped'; // Payment has been authorized and order is ready for shipment, but no items in the order have been shipped.
  const ORDER_STATUS_PARTIALLY_SHIPPED = 'PartiallyShipped'; // One or more (but not all) items in the order have been shipped.
  const ORDER_STATUS_SHIPPED           = 'Shipped'; // All items in the order have been shipped.
  const ORDER_STATUS_CANCELED          = 'Canceled'; // The order was canceled.

  /**
   * Amazon Fulfillment Channels
   */
  const FULFILLMENT_CHANNEL_AFN = 'AFN';
  const FULFILLMENT_CHANNEL_MFN = 'MFN';

  /**
   * Amazon reports status
   */
  const REPORT_STATUS_SUBMITTED    = '_SUBMITTED_';
  const REPORT_STATUS_CANCELLED    = '_CANCELLED_';
  const REPORT_STATUS_IN_PROGRESS  = '_IN_PROGRESS_';
  const REPORT_STATUS_DONE_NO_DATA = '_DONE_NO_DATA_';
  const REPORT_STATUS_DONE_        = '_DONE_';

  /**
   * Amazon Item Conditions
   */
  const ITEM_CONDITION_USED_LIKE_NEW          = 1;
  const ITEM_CONDITION_USED_VERY_GOOD         = 2;
  const ITEM_CONDITION_USED_GOOD              = 3;
  const ITEM_CONDITION_USED_ACCEPTABLE        = 4;
  const ITEM_CONDITION_COLLECTIBLE_LIKE_NEW   = 5;
  const ITEM_CONDITION_COLLECTIBLE_VERY_GOOD  = 6;
  const ITEM_CONDITION_COLLECTIBLE_GOOD       = 7;
  const ITEM_CONDITION_COLLECTIBLE_ACCEPTABLE = 8;
  const ITEM_CONDITION_USED                   = 9; // Refurbished (for Electronics and Camera & Photo only)
  const ITEM_CONDITION_REFURBISHED            = 10; // for Computers, Kitchen & Housewares, Electronics, and Camera & Photo only
  const ITEM_CONDITION_NEW                    = 11;
  const ITEM_CONDITIONS                       = [
    self::ITEM_CONDITION_USED_LIKE_NEW          => 'Used like new',
    self::ITEM_CONDITION_USED_VERY_GOOD         => 'Used very good',
    self::ITEM_CONDITION_USED_GOOD              => 'Used good',
    self::ITEM_CONDITION_USED_ACCEPTABLE        => 'Used acceptable',
    self::ITEM_CONDITION_COLLECTIBLE_LIKE_NEW   => 'Collectible like new',
    self::ITEM_CONDITION_COLLECTIBLE_VERY_GOOD  => 'Collectible very good',
    self::ITEM_CONDITION_COLLECTIBLE_GOOD       => 'Collectible good',
    self::ITEM_CONDITION_COLLECTIBLE_ACCEPTABLE => 'Collectible acceptable',
    self::ITEM_CONDITION_USED                   => 'Used',
    self::ITEM_CONDITION_REFURBISHED            => 'Refurbished',
    self::ITEM_CONDITION_NEW                    => 'New',
  ];

  /**
   * Amazon Label Prep Preference
   */
  const LABEL_PREP_PREFERENCE_SELLER           = 'SELLER_LABEL'; // Seller labels the items in the inbound shipment when labels are required.
  const LABEL_PREP_PREFERENCE_AMAZON_ONLY      = 'AMAZON_LABEL_ONLY'; // item is not included. Amazon attempts to label the items in the inbound shipment when labels are required.
  const LABEL_PREP_PREFERENCE_AMAZON_PREFERRED = 'AMAZON_LABEL_PREFERRED'; // item is included. Amazon attempts to label the items in the inbound shipment when labels are required.

  /**
   * Amazon PrepOwner
   */
  const PREP_OWNER_AMAZON = 'AMAZON';
  const PREP_OWNER_SELLER = 'SELLER';

  /**
   * Amazon Inbound Shipment Status
   */
  const INBOUND_SHIPMENT_STATUS_WORKING   = 'WORKING'; // The shipment was created by the seller, but has not yet shipped.
  const INBOUND_SHIPMENT_STATUS_SHIPPED   = 'SHIPPED'; // The shipment was picked up by the carrier.
  const INBOUND_SHIPMENT_STATUS_CANCELLED = 'CANCELLED'; // When UpdateInboundShipment. The shipment was cancelled by the seller after the shipment was sent to Amazon's fulfillment network.

  /**
   * Amazon IntendedBoxContentsSource
   * How the seller intends to provide Carton Contents Info for this shipment.
   */
  const INBOUND_INTENDED_BOX_CONTENTS_SOURCE_NONE       = 'NONE';
  const INBOUND_INTENDED_BOX_CONTENTS_SOURCE_FEED       = 'FEED';
  const INBOUND_INTENDED_BOX_CONTENTS_SOURCE_2D_BARCODE = '2D_BARCODE';

  /**
   * Amazon Inbound Shipment Types
   */
  const SHIPMENT_TYPE_SP  = 'SP'; // Small Parcel
  const SHIPMENT_TYPE_LTL = 'LTL'; // Less Than Truckload/Full Truckload (LTL/FTL)
  const SHIPMENT_TYPES    = [
    self::SHIPMENT_TYPE_SP,
    self::SHIPMENT_TYPE_LTL,
  ];

  /**
   * Amazon Partnered Carrier Names
   */
  const PARTNERED_CARRIER_UNITED_PARCEL_SERVICE_INC = 'UNITED_PARCEL_SERVICE_INC';
  const PARTNERED_CARRIER_DHL_STANDARD              = 'DHL_STANDARD'; // in Germany (DE) only.

  /**
   * Amazon None Partnered Carrier Names
   */
  // Values in the United Kingdom (UK)
  const NONE_PARTNERED_CARRIER_UK_BUSINESS_POST             = 'BUSINESS_POST';
  const NONE_PARTNERED_CARRIER_UK_DHL_AIRWAYS_INC           = 'DHL_AIRWAYS_INC';
  const NONE_PARTNERED_CARRIER_UK_DHL_UK                    = 'DHL_UK';
  const NONE_PARTNERED_CARRIER_UK_PARCELFORCE               = 'PARCELFORCE';
  const NONE_PARTNERED_CARRIER_UK_DPD                       = 'DPD';
  const NONE_PARTNERED_CARRIER_UK_TNT_LOGISTICS_CORPORATION = 'TNT_LOGISTICS_CORPORATION';
  const NONE_PARTNERED_CARRIER_UK_TNT                       = 'TNT';
  const NONE_PARTNERED_CARRIER_UK_YODEL                     = 'YODEL';
  const NONE_PARTNERED_CARRIER_UK_UNITED_PARCEL_SERVICE_INC = 'UNITED_PARCEL_SERVICE_INC';
  // Values in the United States (US)
  const NONE_PARTNERED_CARRIER_US_DHL_EXPRESS_USA_INC              = 'DHL_EXPRESS_USA_INC';
  const NONE_PARTNERED_CARRIER_US_FEDERAL_EXPRESS_CORP             = 'FEDERAL_EXPRESS_CORP';
  const NONE_PARTNERED_CARRIER_US_UNITED_STATES_POSTAL_SERVICE     = 'UNITED_STATES_POSTAL_SERVICE';
  const NONE_PARTNERED_CARRIER_US_UNITED_UNITED_PARCEL_SERVICE_INC = 'UNITED_PARCEL_SERVICE_INC';
  // Other
  const NONE_PARTNERED_CARRIER_OTHER = 'OTHER';

  /**
   * Amazon Dimensions units
   */
  const DIMENSIONS_UNIT_INCH = 'inches';
  const DIMENSIONS_UNIT_CM   = 'centimeters';
  const DIMENSIONS_UNITS     = [ self::DIMENSIONS_UNIT_INCH, self::DIMENSIONS_UNIT_CM ];

  /**
   * Amazon Weight units
   */
  const WEIGHT_UNIT_POUND = 'pounds';
  const WEIGHT_UNIT_KG    = 'kilograms';
  const WEIGHT_UNITS      = [ self::WEIGHT_UNIT_POUND, self::WEIGHT_UNIT_KG ];

  /**
   * Amazon Seller Freight Classes
   */
  const SELLER_FREIGHT_CLASSES = [
    50,
    55,
    60,
    65,
    70,
    77.5,
    85,
    92.5,
    100,
    110,
    125,
    150,
    175,
    200,
    250,
    300,
    400,
    500,
  ];

  /**
   * Amazon Product Id Types
   */
  const PRODUCT_ID_TYPE_ASIN       = 'ASIN';
  const PRODUCT_ID_TYPE_GCID       = 'GCID';
  const PRODUCT_ID_TYPE_SELLER_SKU = 'SellerSKU';
  const PRODUCT_ID_TYPE_UPC        = 'UPC';
  const PRODUCT_ID_TYPE_EAN        = 'EAN';
  const PRODUCT_ID_TYPE_ISBN       = 'ISBN';
  const PRODUCT_ID_TYPE_JAN        = 'JAN';
  const PRODUCT_ID_TYPES           = [
    self::PRODUCT_ID_TYPE_ASIN,
    self::PRODUCT_ID_TYPE_GCID,
    self::PRODUCT_ID_TYPE_SELLER_SKU,
    self::PRODUCT_ID_TYPE_UPC,
    self::PRODUCT_ID_TYPE_EAN,
    self::PRODUCT_ID_TYPE_ISBN,
    self::PRODUCT_ID_TYPE_JAN,
  ];
}