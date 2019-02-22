import React from "react";
import { renderToString } from "react-dom/server";
import { BrowserRouter, StaticRouter } from "react-router-dom";
import { Helmet } from "react-helmet";
import App from "./CourseApp";

export default (initialProps, context) => {
  if (context.serverSide) {
    console.log(context)
    const renderedHtml = {
      componentHtml: renderToString(
        <StaticRouter
          basename={context.base}
          location={context.location}
          context={{}}
        >
          <App initialProps={initialProps} appContext={context} />
        </StaticRouter>
      ),
      title: Helmet.renderStatic().title.toString()
    }
    return { renderedHtml }
  } else {
    return (
      <BrowserRouter basename={context.base}>
        <App initialProps={initialProps} appContext={context} />
      </BrowserRouter>
    )
  }
}
