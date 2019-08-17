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
  const PREP_OWNERS       = [
    self::PREP_OWNER_AMAZON,
    self::PREP_OWNER_SELLER,
  ];

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
   * Amazon Feed Status
   */
  const FEED_STATUS_AWAITING      = '_AWAITING_ASYNCHRONOUS_REPLY_'; // The request is being processed, but is waiting for external information before it can complete.
  const FEED_STATUS_CANCELLED     = '_CANCELLED_'; // The request has been aborted due to a fatal error.
  const FEED_STATUS_DONE          = '_DONE_'; // The request has been processed.
  const FEED_STATUS_IN_PROGRESS   = '_IN_PROGRESS_'; // The request is being processed.
  const FEED_STATUS_IN_SAFETY_NET = '_IN_SAFETY_NET_'; // The request is being processed, but the system has determined that there is a potential error with the feed, An Amazon seller support associate will contact the seller to confirm whether the feed should be processed.
  const FEED_STATUS_SUBMITTED     = '_SUBMITTED_'; // The request has been received, but has not yet started processing.
  const FEED_STATUS_UNCONFIRMED   = '_UNCONFIRMED_'; // The request is pending.

  /**
   * Amazon Page Type for Package Labels
   */
  const PAGE_TYPE_LETTER_2    = 'PackageLabel_Letter_2'; // Two labels per US Letter label sheet. This is the only valid value for Amazon-partnered shipments in the US that use UPS as the carrier. Supported in Canada and the US.
  const PAGE_TYPE_LETTER_6    = 'PackageLabel_Letter_6'; // Six labels per US Letter label sheet. This is the only valid value for non-Amazon-partnered shipments in the US. Supported in Canada and the US.
  const PAGE_TYPE_A4_2        = 'PackageLabel_A4_2'; // Two labels per A4 label sheet. Supported in France, Germany, Italy, Spain, and the UK.
  const PAGE_TYPE_A4_4        = 'PackageLabel_A4_4'; // Four labels per A4 label sheet. Supported in France, Germany, Italy, Spain, and the UK.
  const PAGE_TYPE_PLAIN_PAPER = 'PackageLabel_Plain_Paper'; // One label per sheet of US Letter paper. Only for non-Amazon-partnered shipments. Supported in all marketplaces.
  const PAGE_TYPES            = [
    self::PAGE_TYPE_LETTER_2,
    self::PAGE_TYPE_LETTER_6,
    self::PAGE_TYPE_A4_2,
    self::PAGE_TYPE_A4_4,
    self::PAGE_TYPE_PLAIN_PAPER,
  ];
}