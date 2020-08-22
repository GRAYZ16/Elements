FROM node:8.2.1-alpine

WORKDIR /elements

RUN npm install -g nodemon@1.11.0

COPY package.json /elements/package.json
RUN npm install && npm ls
RUN mv /elements/node_modules /node_modules

COPY . /elements

CMD ["npm", "start"]
