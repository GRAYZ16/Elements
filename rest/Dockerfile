FROM node:8.2.1-alpine

WORKDIR /elements/rest

RUN npm install -g nodemon@1.11.0

COPY package.json /elements/rest/package.json
RUN npm install && npm ls
RUN mv /elements/rest/node_modules /node_modules

COPY . /elements/rest

CMD ["npm", "start"]
