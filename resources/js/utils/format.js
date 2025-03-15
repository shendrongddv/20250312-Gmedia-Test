/**
 * Format a number as Indonesian Rupiah
 * @param {number} price - The price to format
 * @returns {string} - Formatted price
 */
export const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};
