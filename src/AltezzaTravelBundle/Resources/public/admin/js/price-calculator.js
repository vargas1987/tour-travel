jQuery(function ($, window) {
    'use strict';

    const ROOM_TYPE_TRIPLE = 'triple';

    const PRICE_OPTION_ADULT = 'adult';
    const PRICE_OPTION_TEENAGER = 'teenager';
    const PRICE_OPTION_CHILD = 'child';

    const PRICE_OPTION_VALUE_AMOUNT = 'amount';
    const PRICE_OPTION_VALUE_PERCENT = 'percent';

    const PRICE_OPTION_PER_PERSON_RATE = 'per-person-rate';
    const PRICE_OPTION_SINGLE_SUPPLEMENT = 'single-supplement';
    const PRICE_OPTION_THIRD_ADULT = 'third-adult';
    const PRICE_OPTION_FIRST_TEENAGER_SHARING = 'first-teenager-sharing';
    const PRICE_OPTION_SECOND_TEENAGER_SHARING = 'second-teenager-sharing';
    const PRICE_OPTION_TEENAGER_ALONE = 'teenager-alone';
    const PRICE_OPTION_FIRST_CHILD_SHARING = 'first-child-sharing';
    const PRICE_OPTION_SECOND_CHILD_SHARING = 'second-child-sharing';

    function isNaN(value) {
        value = Number(value);

        return value != value;
    }

    function parseFloatValue(value) {
        value = parseFloat(value);

        if (isNaN(value)) {
            return 0;
        }

        return value;
    }

    function parseIntValue(value) {
        value = parseInt(value);

        if (isNaN(value)) {
            return 0;
        }

        return value;
    }

    var PriceCalculator = function (params) {
        var that = this;
        that.params = params;

        that.teenagerRangeInit = that.params.teenagerRangeInit;
        that.personOptionsList = $(that.params.personOptionsList);
        that.mealPlansList = $(that.params.mealPlansList);
        that.calculateButton = $(that.params.calculateButton);

        $(that.calculateButton).on('click', function () {
            that.calculate();
        });
    };

    PriceCalculator.default = {};

    PriceCalculator.prototype.calculate = function () {
        var that = this;
        var prices = [];
        var basedOnMealPlan = $('[data-based-on]').data('based-on');

        $('.price-tabs .tab-body .tab').each(function (mealPlanKey, mealPlanTab) {
            var mealPlanType = $(mealPlanTab).data('meal-plan-type');

            $(mealPlanTab).find('.admin-price-table tbody tr[data-accommodation-type]').each(function (accommodationTypeKey, accommodationTypeRow) {
                var roomId = $(accommodationTypeRow).data('room-id');
                var roomType = $(accommodationTypeRow).data('room-type');
                var roomSlug = $(accommodationTypeRow).data('room-slug');
                var isSpecificRoomType = $(accommodationTypeRow).data('room-type-specific');

                if (isSpecificRoomType && mealPlanType === basedOnMealPlan) {
                    return true;
                }

                var accommodationType = {
                    adult: $(accommodationTypeRow).data('accommodation-count-' + PRICE_OPTION_ADULT),
                    teenager: $(accommodationTypeRow).data('accommodation-count-' + PRICE_OPTION_TEENAGER),
                    child: $(accommodationTypeRow).data('accommodation-count-' + PRICE_OPTION_CHILD)
                };

                var accommodationTypeSlug = '';
                if (accommodationType.adult > 0) {
                    accommodationTypeSlug = accommodationTypeSlug + accommodationType.adult + 'A';
                }
                if (accommodationType.teenager > 0) {
                    accommodationTypeSlug = accommodationTypeSlug + accommodationType.teenager + 'T';
                }
                if (accommodationType.child > 0) {
                    accommodationTypeSlug = accommodationTypeSlug + accommodationType.child + 'C';
                }


                $(mealPlanTab).find('.admin-price-table thead th[data-season-type]').each(function (seasonTypeKey, seasonTypeCell) {
                    var seasonType = $(seasonTypeCell).data('season-type');
                    var priceInput = $(accommodationTypeRow).find('td[data-season-type="'+seasonType+'"] input');

                    var seasonAccommodationPrice = that.getDefaultAccommodationPriceBySeason(roomType, roomSlug, accommodationType, seasonType);
                    if (isSpecificRoomType && mealPlanType !== basedOnMealPlan) {
                        seasonAccommodationPrice = $('.price-tabs .tab-body .tab[data-meal-plan-type="'+basedOnMealPlan+'"]')
                            .find('.admin-price-table tbody')
                            .find('tr[data-room-id="'+roomId+'"][data-accommodation-type="'+accommodationTypeSlug+'"]')
                            .find('td[data-season-type="'+seasonType+'"]').find('input').val();
                    }

                    var mealPlanAccommodationPrice = that.getDefaultAccommodationPriceByMealPlan(accommodationType, mealPlanType);

                    prices.push({
                        'priceInput': priceInput,
                        'priceValue': parseIntValue(parseIntValue(seasonAccommodationPrice) + parseIntValue(mealPlanAccommodationPrice))
                    });
                });
            });
        });

        $(prices).each(function (key, item) {
            $(item.priceInput).val(item.priceValue);
        });


        var button = $(that.calculateButton);

        setTimeout(function () {
            $(button).addClass('success');
        }, 500);

        setTimeout(function () {
            $(button).removeClass('success');
            $(button).find('.lds-ellipsis').remove();
        }, 20000);
    };

    PriceCalculator.prototype.getDefaultPersonOptionPriceBySeason = function (optionName, roomSlug, seasonType) {
        var that = this;

        var optionPriceType = $(that.personOptionsList)
            .filter('[data-room-slug="'+roomSlug+'"]')
            .find('[data-person-option-name="'+optionName+'"]')
            .find('[data-person-option-type]')
            .find('input:checked').val();

        var optionPriceValue = $(that.personOptionsList)
            .filter('[data-room-slug="'+roomSlug+'"]')
            .find('[data-person-option-name="'+optionName+'"]')
            .find('[data-person-option-season="'+seasonType+'"]')
            .find('input').val();

        switch (optionPriceType) {
            case PRICE_OPTION_VALUE_AMOUNT:
                return parseFloatValue(optionPriceValue);
            case PRICE_OPTION_VALUE_PERCENT:
                var defaultPerPersonRate = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_PER_PERSON_RATE, roomSlug, seasonType);
                return parseFloatValue(defaultPerPersonRate) / 100 * parseFloatValue(optionPriceValue);
        }
    };

    PriceCalculator.prototype.isEnableSupplementOption = function(includeSupplementOptions, possiblyOptions, roomSlug) {
        var that = this;
        includeSupplementOptions = includeSupplementOptions || [];
        possiblyOptions = possiblyOptions || [];

        if (includeSupplementOptions.length === 0) {
            return true;
        }

        var intersect = includeSupplementOptions.filter(function(n) {
            return possiblyOptions.indexOf(n) !== -1;
        });

        var result = false;

        $(intersect).each(function (key, optionName) {
            var supplementOption = $(that.personOptionsList)
                .filter('[data-room-slug="'+roomSlug+'"]')
                .find('[data-person-option-name="'+optionName+'"]')
                .find('input[data-person-option-supplement]');

            if ($(supplementOption).is(':checked')) {
                result = true;
            }
        });

        return result;
    };

    PriceCalculator.prototype.getDefaultAccommodationPriceByMealPlan = function (accommodationType, mealPlanType) {
        var that = this;
        var price = 0;
        var mealPlanPriceBlock = $(that.mealPlansList).find('[data-meal-plan-type="'+mealPlanType+'"]');

        if (mealPlanPriceBlock.length === 0) {
            return parseFloatValue(price);
        }

        var pricePerAdult = $(mealPlanPriceBlock)
            .find('[data-person-type="'+PRICE_OPTION_ADULT+'"]')
            .find('input').val();

        if (accommodationType.teenager > 0) {
            var pricePerTeenager = $(mealPlanPriceBlock)
                .find('[data-person-type="' + PRICE_OPTION_TEENAGER + '"]')
                .find('input').val();
        }

        var pricePerChild = $(mealPlanPriceBlock)
            .find('[data-person-type="'+PRICE_OPTION_CHILD+'"]')
            .find('input').val();

        if (accommodationType.adult > 0) {
            price = price + parseFloatValue(parseFloatValue(pricePerAdult) * accommodationType.adult);
        }

        if (accommodationType.teenager > 0) {
            if (that.teenagerRangeInit) {
                price = price + parseFloatValue(parseFloatValue(pricePerTeenager) * accommodationType.teenager);
            } else {
                price = price + parseFloatValue(parseFloatValue(pricePerAdult) * accommodationType.teenager);
            }
        }

        if (accommodationType.child > 0) {
            price = price + parseFloatValue(parseFloatValue(pricePerChild) * accommodationType.child);
        }

        return parseFloatValue(price);
    };

    PriceCalculator.prototype.getDefaultAccommodationPriceBySeason = function (roomType, roomSlug, accommodationType, seasonType) {
        var that = this;
        var price = 0;

        var perPersonRate = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_PER_PERSON_RATE, roomSlug, seasonType);
        var singleSupplement = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_SINGLE_SUPPLEMENT, roomSlug, seasonType);
        var thirdAdult = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_THIRD_ADULT, roomSlug, seasonType);
        var includeSupplementOptions = [];
        var possiblyOptions = [];

        if (that.teenagerRangeInit) {
            var firstTeenagerSharing = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_FIRST_TEENAGER_SHARING, roomSlug, seasonType);
            var secondTeenagerSharing = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_SECOND_TEENAGER_SHARING, roomSlug, seasonType);
            var teenagerAlone = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_TEENAGER_ALONE, roomSlug, seasonType);
        } else {
            accommodationType.adult = accommodationType.adult + accommodationType.teenager;
            accommodationType.teenager = 0;
        }

        var firstChildSharing = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_FIRST_CHILD_SHARING, roomSlug, seasonType);
        var secondChildSharing = that.getDefaultPersonOptionPriceBySeason(PRICE_OPTION_SECOND_CHILD_SHARING, roomSlug, seasonType);

        if (accommodationType.child > 0) {
            price = price + parseFloatValue(firstChildSharing);
            includeSupplementOptions.push(PRICE_OPTION_FIRST_CHILD_SHARING);

            if (accommodationType.child > 1) {
                price = price + parseFloatValue(parseIntValue(accommodationType.child - 1) * parseFloatValue(secondChildSharing));
                includeSupplementOptions.push(PRICE_OPTION_SECOND_CHILD_SHARING);
            }
        }

        if (accommodationType.teenager > 0) {
            if (accommodationType.adult > 0) {
                price = price + parseFloatValue(firstTeenagerSharing);
                includeSupplementOptions.push(PRICE_OPTION_FIRST_TEENAGER_SHARING);

                if (accommodationType.teenager > 1) {
                    price = price + parseFloatValue(parseIntValue(accommodationType.teenager - 1) * parseFloatValue(secondTeenagerSharing));
                    includeSupplementOptions.push(PRICE_OPTION_SECOND_TEENAGER_SHARING);
                }
            }

            if (accommodationType.adult === 0) {
                price = price + parseFloatValue(teenagerAlone);
                price = price + parseFloatValue(parseIntValue(accommodationType.teenager - 1) * parseFloatValue(secondTeenagerSharing));
            }
        }

        if (accommodationType.adult > 0) {
            if (accommodationType.adult === 1) {
                price = price + parseFloatValue(perPersonRate);

                switch (true) {
                    case accommodationType.teenager === 0 && accommodationType.child > 0:
                        possiblyOptions.push(PRICE_OPTION_FIRST_CHILD_SHARING);
                        possiblyOptions.push(PRICE_OPTION_SECOND_CHILD_SHARING);
                        break;
                    case accommodationType.teenager > 0 && accommodationType.child === 0:
                    case accommodationType.teenager > 0 && accommodationType.child > 0:
                        possiblyOptions.push(PRICE_OPTION_FIRST_TEENAGER_SHARING);
                        possiblyOptions.push(PRICE_OPTION_SECOND_TEENAGER_SHARING);
                        break;
                }

                if (that.isEnableSupplementOption(includeSupplementOptions, possiblyOptions, roomSlug)) {
                    price = price + parseFloatValue(singleSupplement);
                }
            }

            if (accommodationType.adult === 2) {
                price = price + parseFloatValue(parseFloatValue(perPersonRate) * accommodationType.adult);
            }

            if (accommodationType.adult === 3 && accommodationType.child === 0 && accommodationType.teenager === 0) {
                price = price + parseFloatValue(parseFloatValue(perPersonRate) * 2);
                price = price + parseFloatValue(parseIntValue(accommodationType.adult - 2) * parseFloatValue(thirdAdult));
            } else if (accommodationType.adult > 2) {
                price = price + parseFloatValue(parseFloatValue(perPersonRate) * accommodationType.adult);
            }
        }

        return parseFloatValue(price);
    };

    function Plugin(params) {
        return this.each(function () {
            var $this = $(this);

            var paramsMerge = $.extend({}, PriceCalculator.default, params);
            $this.data('altezza.price.calculator', new PriceCalculator(paramsMerge));
        });
    }

    $.fn.priceCalculator = Plugin;
    $.fn.priceCalculator.Constructor = PriceCalculator;
});
