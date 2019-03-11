import React, { Component } from "react";
import * as API from "../services/api";
// import url from "../components/1.xml";

// const url ="https://hub.tatet.net/seller-949.xml";

export default class ListOffers extends Component {
  state = {
    offers: "",
    isLoading: false,
    result: "",
    error: ""
  };

  async componentDidMount() {
    this.setState({ isLoading: true });
    try {
      let xmlUrl = this.props.xmlUrl;
      // xmlUrl = url;

      console.log("this.props.xmlUrl: ", this.props.xmlUrl);

      let offers = await API.getBodyXml(xmlUrl);
      // console.log('offers: ', offers);

      let xml = offers;
      var convert = require("xml-js");
      let result = convert.xml2js(xml, {
        compact: true,
        spaces: 0,
        textKey: "text",
        attributesKey: "attributes",
        cdataKey: "cdata"
      });

      // console.log("result: ", result.yml_catalog.shop);
      // console.log(
      //   "result.yml_catalog.shop.offers: ",
      //   result.yml_catalog.shop.offers.offer
      // );
      // console.log('result: ', result);

      this.setState(() => ({
        offers,
        isLoading: false,
        result
      }));
    } catch (error) {
      this.setState({ error, isLoading: false });
    }
  }

  render() {
    const { result, isLoading, error } = this.state;
    return (
      <div style={{ width: "700px" }}>
        {isLoading && <div>Loading...</div>}
        {error && <div>{error}</div>}
        {result && (
          <a href={this.props.xmlUrl} target="_blank" rel="noopener noreferrer">
            {this.props.xmlUrl}
          </a>
        )}
        {result && (
          <div>
            Всего товаров: {result.yml_catalog.shop.offers.offer.length}
          </div>
        )}
        {result && (
          <div>
            Всего фото:{" "}
            {result.yml_catalog.shop.offers.offer.reduce(
              (acc, value) =>
                acc +
                (value.picture && value.picture.text ? 1 : 0) +
                (value.picture && value.picture.length
                  ? value.picture.length
                  : 0),
              0
            )}
          </div>
        )}
        <ul>
          {result &&
            result.yml_catalog.shop.offers.offer.map((offer, index) => (
              <li key={offer.attributes.id}>
                {/* {offer.picture.length && <div>Всего фото: {offer.picture.length}</div>} */}
                {offer.name && <div>name: {offer.name.text}</div>}
                <div>available: {offer.attributes.available}</div>
                <div>id: {offer.attributes.id}</div>
                <div>categoryId: {offer.categoryId.text}</div>
                <div>currencyId: {offer.currencyId.text}</div>
                <div>price: {offer.price.text}</div>
                <div>
                  {/* url: <a href={offer.url.text}>{offer.url.text}</a> */}
                </div>
                {offer.description && (
                  <div
                    className="description"
                    dangerouslySetInnerHTML={{
                      __html: offer.description.cdata
                    }}
                  />
                )}
                <div>
                  <ul>
                    <li>
                      {offer.param &&
                        offer.param.length &&
                        offer.param.map(item => (
                          <div key={item.attributes.name}>
                            {item.attributes.name} -- {item.text}
                          </div>
                        ))}
                      {offer.param && !offer.param.length && (
                        <div>
                          {offer.param.attributes.name} -- {offer.param.text}
                        </div>
                      )}
                    </li>
                  </ul>
                </div>
                <div>
                  <ul>
                    <li
                      style={{
                        display: "flex",
                        flexWrap: "wrap",
                        justifyContent: "center"
                      }}
                    >
                      {offer.picture &&
                        offer.picture.length &&
                        offer.picture.map(item => (
                          <div key={item.text} style={{ margin: "10px" }}>
                            <a
                              href={item.text}
                              target="_blank"
                              rel="noopener noreferrer"
                            >
                              <img
                                height="190"
                                src={item.text}
                                alt={item.text}
                              />
                            </a>
                          </div>
                        ))}
                      {offer.picture && !offer.picture.length && (
                        <div style={{ margin: "10px" }}>
                          <a
                            href={offer.picture.text}
                            target="_blank"
                            rel="noopener noreferrer"
                          >
                            <img
                              height="190"
                              src={offer.picture.text}
                              alt={offer.picture.text}
                            />
                          </a>
                        </div>
                      )}
                    </li>
                    <div className="number">numberOffers: {index + 1}</div>
                    <hr />
                  </ul>
                </div>
              </li>
            ))}
        </ul>
      </div>
    );
  }
}
