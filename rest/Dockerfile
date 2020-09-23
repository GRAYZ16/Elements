FROM node:alpine AS development

WORKDIR /elements/rest

RUN npm config set unsafe-perm true
RUN npm install -g nodemon@1.11.0

ENV NODE_ENV development

COPY package.json /elements/rest/package.json
RUN npm install && npm ls
RUN mv /elements/rest/node_modules /node_modules

COPY ./src /elements/rest/src

CMD ["npm", "start"]

FROM development AS build

RUN npm run build

FROM nginx:1.17.9 AS production

COPY --from=builder /build /usr/share/nginx/html
