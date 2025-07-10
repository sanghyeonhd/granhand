import {StyleSheet} from 'react-native';

import { Images, BaseColor, BaseSetting } from "../../config/index";
import { horizontalScale, scaleFontSize, verticalScale } from '../../utils/Scale';

const glSt = StyleSheet.create({
	flex:{
		flexDirection:"row"
	},
	flexc:{
		flexDirection:"column"
	},
	alcenter:{
		alignItems:"center"
	},
	alstart:{
		alignItems:"flex-start"
	},
	alend:{
		alignItems:"flex-end"
	},
	jubetween:{
		justifyContent:"space-between"
	},
	juaround:{
		justifyContent:"space-around"
	},
	jucenter :{
		justifyContent:"center"
	},
	justart :{
		justifyContent:"flex-start"
	},
	juend :{
		justifyContent:"flex-end"
	},
	py7 : {
		paddingVertical:verticalScale(7)
	},
	py20 : {
		paddingVertical:verticalScale(20)
	},
	py16 : {
		paddingVertical:verticalScale(16)
	},
	py22 : {
		paddingVertical:verticalScale(22)
	},
	py24 : {
		paddingVertical:verticalScale(24)
	},
	px14 : {
		paddingHorizontal:horizontalScale(14)
	},
	px16 : {
		paddingHorizontal:horizontalScale(16)
	},
	px24 : {
		paddingHorizontal:horizontalScale(24)
	},
	h20: {
		height:verticalScale(20)
	},
	h38: {
		height:verticalScale(38)
	},
	h42: {
		height:verticalScale(42)
	},
	h46: {
		height:verticalScale(46)
	},
	h50: {
		height:verticalScale(50)
	},
	h52: {
		height:verticalScale(52)
	},
	h54:{
		height:verticalScale(54)
	},
	h58:{
		height:verticalScale(58)
	},
	h60:{
		height:verticalScale(60)
	},
	h64:{
		height:verticalScale(60)
	},
	mt8:{
		marginTop:verticalScale(8)
	},
	mt16:{
		marginTop:verticalScale(16)
	},
	mt32:{
		marginTop:verticalScale(32)
	},
	mt28:{
		marginTop:verticalScale(28)
	},
	mb8:{
		marginBottom:verticalScale(8)
	},
	mb18:{
		marginBottom:verticalScale(18)
	},
	mb60:{
		marginBottom:verticalScale(60)
	},
	mb14:{
		marginBottom:verticalScale(16)
	},
	mb44:{
		marginBottom:verticalScale(44)
	},
	mb48:{
		marginBottom:verticalScale(48)
	},
	mb38:{
		marginBottom:verticalScale(38)
	},
	mb16:{
		marginBottom:verticalScale(16)
	},
	mb2:{
		marginBottom:verticalScale(2)
	},
	mb4:{
		marginBottom:verticalScale(4)
	},
	mb20:{
		marginBottom:verticalScale(20)
	},
	mb22:{
		marginBottom:verticalScale(22)
	},
	mb23:{
		marginBottom:verticalScale(23)
	},
	mb24:{
		marginBottom:verticalScale(24)
	},
	mb3:{
		marginBottom:verticalScale(3)
	},
	mb12:{
		marginBottom:verticalScale(12)
	},
	mb30:{
		marginBottom:verticalScale(30)
	},
	mb32:{
		marginBottom:verticalScale(32)
	},
	mb40:{
		marginBottom:verticalScale(40)
	},
	mb58:{
		marginBottom:verticalScale(58)
	},
	mb74:{
		marginBottom:verticalScale(74)
	},
	mr3:{
		marginRight:horizontalScale(3)
	},
	mr4:{
		marginRight:horizontalScale(4)
	},
	mr10:{
		marginRight:horizontalScale(10)
	},
	mr12:{
		marginRight:horizontalScale(12)
	},
	mr16:{
		marginRight:horizontalScale(16)
	},
	mr20:{
		marginRight:horizontalScale(20)
	},
	mr24:{
		marginRight:horizontalScale(24)
	},
	mr2:{
		marginRight:horizontalScale(2)
	},
	mr8:{
		marginRight:horizontalScale(8)
	},
	ml10 : {
		marginLeft:horizontalScale(10)
	},
	ml8 : {
		marginLeft:horizontalScale(8)
	},
	mr18 : {
		marginRight:horizontalScale(18)
	},
	mh16:{
		marginHorizontal:verticalScale(16)
	},
	mb10:{
		marginBottom:verticalScale(10)
	},
	mb24:{
		marginBottom:verticalScale(24)
	},
	mb36:{
		marginBottom:verticalScale(36)
	},
	mx14:{
		marginHorizontal:verticalScale(14)
	},
	mx20:{
		marginHorizontal:verticalScale(20)
	},
	pt10 :{
		paddingTop:verticalScale(10)
	},
	pt16 :{
		paddingTop:verticalScale(16)
	},
	pt24 :{
		paddingTop:verticalScale(24)
	},
	pt30 :{
		paddingTop:verticalScale(30)
	},
	pt32 :{
		paddingTop:verticalScale(32)
	},
	pt50 :{
		paddingTop:verticalScale(50)
	},
	pt54 :{
		paddingTop:verticalScale(54)
	},
	pt48 :{
		paddingTop:verticalScale(48)
	},
	pb16 :{
		paddingBottom:verticalScale(16)
	},
	pb24 :{
		paddingBottom:verticalScale(24)
	},
	pb37 :{
		paddingBottom:verticalScale(37)
	},
	py2 :{
		paddingVertical:verticalScale(2)
	},
	py4 :{
		paddingVertical:verticalScale(4)
	},
	py32 :{
		paddingVertical:verticalScale(32)
	},
	px8 :{
		paddingHorizontal:horizontalScale(8)
	},
	py7 :{
		paddingVertical:verticalScale(7)
	},
	py36 :{
		paddingVertical:verticalScale(36)
	},
	px13 :{
		paddingHorizontal:horizontalScale(13)
	},
	px12 :{
		paddingHorizontal:horizontalScale(12)
	},
	px2 :{
		paddingHorizontal:horizontalScale(2)
	},
	px22 :{
		paddingHorizontal:horizontalScale(22)
	},
	px23 :{
		paddingHorizontal:horizontalScale(23)
	},
	pl24 :{
		paddingLeft:horizontalScale(24)
	},
	c000000  :{
		color:"#000000",
	},
	cFDFBF5:{
		color:"#FDFBF5",
	},
	c111111:{
		color:"#111111"
	},
	c5E5955:{
		color:"#5E5955"
	},
	c322A24:{
		color:"#322A24"
	},

	cC0BCB6:{
		color:"#C0BCB6"
	},
	cDBD7D0:{
		color:"#DBD7D0"
	},
	cE9E6E0:{
		color:"#E9E6E0"
	},

	cFF3E24:{
		color:"#FF3E24"
	},
	cF9E3BE:{
		color:"#F9E3BE"
	},
	cF9B78D:{
		color:"#F9B78D"
	},
	cD0505D:{
		color:"#D0505D"
	},
	c1D1717:{
		color:"#1D1717"
	},
	cE34234:{
		color:"#E34234"
	},
	ce5e7eb:{
		color:"#e5e7eb"
	},
	cDDDBD5:	{
		color:"#DDDBD5"
	},
	c6F6963:{
		color:"#6F6963"
	},
	cFFFFFF:{
		color:"#FFFFFF"
	},
	cFF6B62: {
		color:"#FF6B62"
	},

	c231815: {
		color:"#231815"
	},

	
	bgF6F4EE:{
		backgroundColor:"#F6F4EE"
	},
	bgFDFBF5:{
		backgroundColor:"#FDFBF5"
	},
	bgDBD7D0:{
		backgroundColor:"#DBD7D0"
	},
	bg322A24: {
		backgroundColor:"#322A24"
	},
	bgFFFFFF:	{
		backgroundColor:"#FFFFFF"
	},
	bgC0BCB6:{
		backgroundColor:"#C0BCB6"
	},
	bgE9E6E0:{
		backgroundColor:"#E9E6E0"
	},
	text10m	:{
		fontSize:scaleFontSize(10),
		fontFamily:"Pretendard-Medium",
		lineHeight:scaleFontSize(18),
	},
	text10b	:{
		fontSize:scaleFontSize(10),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(18),
	},
	text11b	:{
		fontSize:scaleFontSize(11),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(11),
	},
	text12r	:{
		fontSize:scaleFontSize(12),
		fontFamily:"Pretendard-Regular",
		lineHeight:scaleFontSize(20),
	},
	text12m	:{
		fontSize:scaleFontSize(12),
		fontFamily:"Pretendard-Medium",
		lineHeight:scaleFontSize(20),
	},
	text12b	:{
		fontSize:scaleFontSize(12),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(20),
	},
	text13r	:{
		fontSize:scaleFontSize(13),
		fontFamily:"Pretendard-Regular",
		lineHeight:scaleFontSize(22),
	},
	text14r	:{
		fontSize:scaleFontSize(14),
		fontFamily:"Pretendard-Regular",
		lineHeight:scaleFontSize(22),
	},
	text14m	:{
		fontSize:scaleFontSize(14),
		fontFamily:"Pretendard-Medium",
		lineHeight:scaleFontSize(22),
	},
	text14b	:{
		fontSize:scaleFontSize(14),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(22),
	},
	text16r	:{
		fontSize:scaleFontSize(16),
		fontFamily:"Pretendard-Regular",
		lineHeight:scaleFontSize(24),
	},
	text16m	:{
		fontSize:scaleFontSize(16),
		fontFamily:"Pretendard-Medium",
		lineHeight:scaleFontSize(24),
	},
	text16b	:{
		fontSize:scaleFontSize(16),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(24),
	},
	text18r	:{
		fontSize:scaleFontSize(18),
		fontFamily:"Pretendard-Regular",
		lineHeight:scaleFontSize(26),
	},
	text18m	:{
		fontSize:scaleFontSize(18),
		fontFamily:"Pretendard-Medium",
		lineHeight:scaleFontSize(26),
	},
	text18b	:{
		fontSize:scaleFontSize(18),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(26),
	},
	text20b	:{
		fontSize:scaleFontSize(20),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(32),
	},
	text32b	:{
		fontSize:scaleFontSize(32),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(42),
	},
	text24b :{
		fontSize:scaleFontSize(24),
		fontFamily:"Pretendard-Bold",
		lineHeight:scaleFontSize(42),
	},
	borderC0BCB6:{
		borderWidth:1,
		borderColor:"#C0BCB6"
	},
	borderFF3E24:{
		borderWidth:1,
		borderColor:"#FF3E24"
	},
	border322A24:{
		borderWidth:1,
		borderColor:"#322A24"
	},
	BorderE9E6E0 :{
		borderWidth:1,
		borderColor:"#E9E6E0"
	},
	border6F6963 :{
		borderWidth:1,
		borderColor:"#6F6963"
	},
	borderDBD7D0:{
		borderWidth:1,
		borderColor:"#DBD7D0"
	},
	showdow1:{
		backgroundColor: '#FDFBF5',
    	shadowColor: '#000',
    	shadowOffset: { width: 0, height: 4 },
    	shadowOpacity: 0.03,
    	shadowRadius: 10,
    	elevation: 6, // Android에서 그림자 효과
	}
	
});
export default glSt;