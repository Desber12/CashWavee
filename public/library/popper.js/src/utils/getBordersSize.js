/*
 * Helper to detect border of a given element
 * @method
 * @memberof Popper.Utils
 * @param {CSSStyleDeclaration} styles
 * Result of `getStyleComputedProperty` on the given element
 * @param {String} axis - `x` or `y`
 * @return {number} border - The border size of the given axis
 */

export default function getBorderSize(styles, axis) {
  const sideA = axis === 'x' ? 'Left' : 'Top';
  const sideB = sideA === 'Left' ? 'Right' : 'Bottom';

  return (
    parseFloat(styles[`border${sideA}Width`]) +
    parseFloat(styles[`border${sideB}Width`])
  );
}
