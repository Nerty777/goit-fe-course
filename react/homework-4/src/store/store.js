import { createStore, applyMiddleware } from 'redux';
import { composeWithDevTools } from 'redux-devtools-extension';
import thunk from 'redux-thunk';

import rootReducer from '../modules/rootReducer';

const middlewares = applyMiddleware(thunk);

const store = createStore(rootReducer, composeWithDevTools(middlewares));

export default store;

// let store = {
//   menu: {
//     items: [],
//     filter: "",
//     category: []
//     isLoading: false,
//     error: null
//   },
// };
