<template>
    <div class="row">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <p class="mt-2 mb-2 fw-bold">This is the transactions page!</p>
            <div class="accordion mt-2 mb-2" id="accordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                            Transaction Address
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="form-group row mb-2">
                                <div class="col-sm-6">
                                    <input id="inputAddress" class="form-control mb-2" type="text" placeholder="Input address..." aria-label="default input example" ref="addressInput" :class="{ 'is-invalid': validationErrors.address.error }" :disabled="isTxLoading">
                                    <div class="invalid-feedback">
                                        {{ validationErrors.address.message }}
                                    </div>
                                </div>
                                <div id="helperBlock" class="form-text mb-2">
                                    Example: 0x1D2eE51a70F079Fd28af6089458Cf5b158f8F736
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="blockNumberInput" class="col-sm-2 col-form-label fw-bold text-nowrap">From block:</label>
                                <div class="col-sm-4">
                                    <input type="number" v-model="blockNumber" :disabled="isTxLoading" class="form-control" id="blockNumberInput" placeholder="Enter a block number" min="0" max="99999999" step="1">
                                </div>
                            </div>
                            <button class="btn btn-dark col-2 mt-2" type="button" :disabled="isTxLoading" @click="showTransactions()">
                                <span v-if="isTxLoading" class="spinner-border spinner-border-sm" role="loadTx" aria-hidden="true"></span>
                                {{ isTxLoading ? "Loading..." : "Load" }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                            Test Addresses
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between align-items-center mb-2" v-for="(addr, index) in randomAddresses" :key="index">
                                <span class="text-break me-2" :class="{ 'fw-bold': copiedAddress[index] }">{{ addr }}</span>
                                <button class="btn btn-dark" @click="copyToClipboard(addr, index)">
                                    <span v-if="copiedAddress[index]">Copied!</span>
                                    <span v-else>Copy</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2 mb-5">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of transactions
                </div>
                <div class="card-body">
                    <table id="txTable" class="table table-dark table-striped-columns">
                        <thead>
                            <tr>
                                <th>$</th>
                                <th>ID</th>
                                <th>Block Number</th>
                                <th>Token Symbol</th>
                                <th>Token Value</th>
                                <th>ETH Used</th>
                                <th>Transaction Hash</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Time Stamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="tknTransactions.length === 0">
                                <td colspan="10" class="text-center">No Data Available</td>
                            </tr>
                            <tr v-else v-for="(transaction, index) in tknTransactions" :key="index">
                                <td>
                                    <button v-if="isSender(transaction.from)" class="btn btn-danger btn-sm">Out</button>
                                    <button v-else class="btn btn-success btn-sm">In</button>
                                </td>
                                <td>{{ index + 1 }}</td>
                                <td>{{ transaction.blockNumber }}</td>
                                <td>{{ transaction.tokenSymbol }}</td>
                                <td>{{ formatTknValue(transaction.value, transaction.tokenDecimal) }}</td>
                                <td>{{ formatEthUsed(transaction.gasUsed, transaction.gasPrice) }}</td>
                                <td>{{ transaction.hash }}</td>
                                <td>{{ transaction.from }}</td>
                                <td>{{ transaction.to }}</td>
                                <td>{{ formatTimeStamp(transaction.timeStamp) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>$</th>
                                <th>ID</th>
                                <th>Block Number</th>
                                <th>Token Symbol</th>
                                <th>Token Value</th>
                                <th>ETH Used</th>
                                <th>Transaction Hash</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Time Stamp</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Transactions',
    components: {},
    data() {
        return {
            address: "",
            blockNumber: 0,
            isTxLoading: false,
            tknTransactions: [],
            copiedAddress: {},
            validationErrors: {
                address: { error: false, message: null }
            },
            randomAddresses: [
                "0x235fFb960a34A639E343A3AC1af118B0285c0447",
                "0x389044F3ac7472060A0618116e3624A5f0f20F28",
                "0x3fC91A3afd70395Cd496C647d5a6CC9D4B2b7FAD",
                "0xecaECDc673758D3386B5F906507E8Ad7326Af514",
                "0x653A025AEB6Fc0357229a0e83283ADCC8271E19A",
                "0x7a250d5630B4cF539739dF2C5dAcb4c659F2488D",
                "0xbDc98BE7dC618EEA0142b01390B7FB5B33c500fd",
            ],
        };
    },
    watch: {
        blockNumber(newBlockNumber) {
            if (!this.blockNumber || this.blockNumber === '' || !/^\d+$/.test(this.blockNumber) || this.blockNumber > 99999999 || this.blockNumber.toString().length === 9) {
                this.blockNumber = 0;
            }
        }
    },
    methods: {
        showTransactions() {
            this.address = this.$refs.addressInput.value;
            if (this.checkAddress()) {
                return;
            }
            this.isTxLoading = true;
            axios.get("/api/get-transactions", { params: { address: this.address } }).then((res) => {
                console.log(res.data);
                this.tknTransactions = res.data.payload;
            }).catch((err) => {
                console.log(err);
                his.tknTransactions = [];
            }).finally(() => {
                this.isTxLoading = false
            });
        },
        checkAddress() {
            if (!this.address) {
                this.validationErrors.address.error = true;
                this.validationErrors.address.message = "The address field is required!";
                return this.validationErrors.address.error;
            }
            if(!this.isValidAddress()) {
                this.validationErrors.address.error = true;
                this.validationErrors.address.message = "The address field is invalid!";
                return this.validationErrors.address.error;
            }
            this.validationErrors.address.error = false;
            this.validationErrors.address.message = null;
            return this.validationErrors.address.error;
        },
        isValidAddress() {
            const regex = /^0x[a-fA-F0-9]{40}$/;
            return regex.test(this.address);
        },
        isSender(fromAddress) {
            return fromAddress.toLowerCase() === this.address.toLowerCase();
        },
        formatTknValue(value, decimals) {
            return (value / Math.pow(10, decimals)).toFixed(6);
        },
        formatEthUsed(gasUsed, gasPrice) {
            return (gasUsed * gasPrice / Math.pow(10, 18)).toFixed(6);
        },
        formatTimeStamp(unixTimestamp) {
            const date = new Date(unixTimestamp * 1000);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
        copyToClipboard(address, index) {
            navigator.clipboard.writeText(address)
            .then(() => {
                this.$set(this.copiedAddress, index, true);
                setTimeout(() => {
                    this.$delete(this.copiedAddress, index);
                }, 1000);
            })
            .catch(err => {
                console.error('Failed to copy: ', err);
            });
        },
    },
    beforeDestroy() {}
};
</script>
