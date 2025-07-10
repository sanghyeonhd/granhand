import {PixelRatio, Platform, Dimensions} from 'react-native';

const {width, height} = Dimensions.get('window');

const realWidth = height > width ? width : height;

import DeviceInfo from 'react-native-device-info';

const isTablet = () => {
  let pixelDensity = PixelRatio.get();
  let adjustedWidth = width * pixelDensity;
  let adjustedHeight = height * pixelDensity;
  if (pixelDensity < 2 && (adjustedWidth >= 1000 || adjustedHeight >= 1000)) {
    return true;
  } else {
    return (
      pixelDensity === 2 && (adjustedWidth >= 1920 || adjustedHeight >= 1920)
    );
  }
};

const isSmallDevice = width <= 390 && !DeviceInfo.hasNotch();

//디자인 픽셀 기준으로 비율 계산하는 메소드
const guidelineBaseWidth = 390;
const guidelineBaseHeight = 797;

const verticalPercentageScale = percentage => (percentage / 100) * height;
const horizontalPercentageScale = percentage => (percentage / 100) * width;

const horizontalScale = size => (width / guidelineBaseWidth) * size;
const verticalScale = size => (height / guidelineBaseHeight) * size;

const scaleFontSize = size => {
  let divider = isTablet() ? 600 : 390;
  return Math.round((size * realWidth) / divider);
};

const screenWidth = width;
const screenHeight = height;

/**
 * 제공된 넓이 백분율을 픽셀로 변환 (dp).
 * @param  {string} widthPercent UI 요소가 포함해야 하는 화면 너비의 백분율(%) 
 * @return {number}              현재 장치의 화면 너비에 따라 계산된 dp.
 */
const widthPercentageToDP = widthPercent => {
  // 문자열 백분율 입력값을 숫자로 변환
  const elemWidth =
    typeof widthPercent === 'number' ? widthPercent : parseFloat(widthPercent);

  // 레이아웃을 반올림하려면 PixelRatio.roundToRearestPixel 메서드를 사용
  return PixelRatio.roundToNearestPixel((screenWidth * elemWidth) / 100);
};

/**
 * 제공된 높이 백분율을 픽셀로 변환 (dp).
 * @param  {string} heightPercent UI 요소가 포함해야 하는 화면 높이의 백분율(%) 
 * @return {number}               현재 장치의 화면 높이에 따라 계산된 dp.
 */
const heightPercentageToDP = heightPercent => {
  // 문자열 백분율 입력값을 숫자로 변환
  const elemHeight =
    typeof heightPercent === 'number'
      ? heightPercent
      : parseFloat(heightPercent);

  // 레이아웃을 반올림하려면 PixelRatio.roundToRearestPixel 메서드를 사용
  return PixelRatio.roundToNearestPixel((screenHeight * elemHeight) / 100);
};



export {
  horizontalScale,
  verticalScale,
  scaleFontSize,
  screenWidth,
  screenHeight,
  verticalPercentageScale,
  horizontalPercentageScale,
  isSmallDevice,
  widthPercentageToDP,
  heightPercentageToDP,
};