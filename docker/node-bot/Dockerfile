FROM node:20-alpine

# Install dependencies
RUN apk add --no-cache \
    python3 \
    make \
    g++ \
    libc6-compat \
    && rm -rf /var/cache/apk/*

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

CMD ["node", "index.cjs"]
