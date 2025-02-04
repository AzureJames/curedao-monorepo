import * as envHelper from "@curedao/env-helper";
const port = envHelper.getEnvOrException("EXPRESS_PORT");
const fallbackServerUrl = `http://localhost:${port}`;
const values = {
  serverPort: port,
  serverOrigin: process.env[envHelper.envNames.EXPRESS_ORIGIN] || fallbackServerUrl,
  QM_API_ORIGIN: process.env[envHelper.envNames.QM_API_ORIGIN] || 'https://app.quantimo.do',
  loginSuccessRedirect: process.env[envHelper.envNames.LOGIN_SUCCESS_REDIRECT] || "/#/app/onboarding",
  loginFailureRedirect: "/#/app/login",
  loginPath: "/#/app/login"
}
export { values };
