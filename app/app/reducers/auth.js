import * as actionTypes from "../actions/actionTypes";


const baseData = {
	isLogin:false,
	userData:[],
}


export default (state = baseData, action) => {
	switch (action.type) {
		case actionTypes.SETLOGIN:
			return action.payload;
		case actionTypes.SETLOGOUT:
			return action.payload;
		default:
			return state;
	}
};
