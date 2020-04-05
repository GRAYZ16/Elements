FROM node:12-alpine
WORKDIR /elements
COPY . .
RUN yarn install --production
CMD ["node", "/elements/rest/index.js"]