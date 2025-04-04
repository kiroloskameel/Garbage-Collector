const { createProxyMiddleware } = require('http-proxy-middleware');
const express = require('express');

const app = express();

const targetUrl = 'http://192.168.0.105';

app.use('/', createProxyMiddleware({
  target: targetUrl,
  changeOrigin: true,
}));

const PORT = 8080;
app.listen(PORT, () => {
  console.log(`Proxy server is running on http://localhost:${PORT}`);
});
