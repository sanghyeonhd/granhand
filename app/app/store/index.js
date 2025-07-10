import AsyncStorage from '@react-native-async-storage/async-storage';
import { legacy_createStore as createStore, applyMiddleware, combineReducers, compose } from "redux";
import { persistStore, persistReducer } from "redux-persist";

import logger from "redux-logger";
import rootReducer from "../reducers";

const thunk = require('redux-thunk').thunk;
/**
 * Redux Setting
 */
const persistConfig = {
    key: "root",
    storage: AsyncStorage,
    timeout: 86400
};

let middleware = [thunk];
if (process.env.NODE_ENV === `development`) {
    //middleware.push(logger);
}

const composeWithDevTools =
  window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose

const middlewareEnhancer = applyMiddleware(thunk)
const composedEnhancers = composeWithDevTools(middlewareEnhancer)

const persistedReducer = persistReducer(persistConfig, rootReducer);
const store = createStore(persistedReducer, composedEnhancers);
const persistor = persistStore(store);

export { store, persistor };
