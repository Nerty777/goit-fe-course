// import axios from 'axios';

// const proxy = {
//   host: 'https://cors-anywhere.herokuapp.com/',
//   port: 443,
// };


const getBodyXml = async (xmlUrl) => {
  // const response = await axios.get(xmlUrl, { crossdomain: true });
  // const response = await axios.get(xmlUrl, {
  //   proxy: {
  //     host: 'https://cors-anywhere.herokuapp.com/',
  //     port: 443,
  //   }
  //   });

  // console.log('response: ', response.data);
  // return response.data;

  const proxyurl = "https://cors-anywhere.herokuapp.com/";
  const url = xmlUrl; // site that doesnt send Access-Control-*
  console.log('url: ', url);
  let bb = fetch(proxyurl + url) // https://cors-anywhere.herokuapp.com/https://example.com
  .then(response => response.text())
  .catch(() => console.log("Cant access " + url + " response. Blocked by browser?"))
  console.log('bb: ', bb);
  return bb;

};

export {
  getBodyXml,
};
