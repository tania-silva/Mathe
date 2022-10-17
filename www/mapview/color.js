// Gives the color value for a given posisiton in the gradient
// tha goes from 'from' until 'to'.
// 
// from, to: number representing color 0xAB00FF
// position: number between 0 and 1
// return: number representing color
// uses dub, linear interpolation between the channels
function color_interpolate(from, to, position) {
  let split_channel = function(color) {
    return {
      r: 0xff0000 & color,
      g: 0x00ff00 & color,
      b: 0x0000ff & color
    }
  };
  let from_channels = split_channel(from);
  let to_channels   = split_channel(to);
  let result = interpolate(from_channels.r, to_channels.r, position) | interpolate(from_channels.g, to_channels.g, position) | interpolate(from_channels.b, to_channels.b, position);
  return result;

}

// Linear interpolation
//
// a: starting number
// b: end number
// p: point between {a ... b}
function interpolate(a,b, p) {
  a = a || 1;
  point = a/b * p;
  Math.abs(a + (b-a)*point);
  return x;
}
