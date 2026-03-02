<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\MerchantProductOptionDataImport\Business;

use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\MerchantProductOptionDataImport\Business\Model\Step\ApprovalStatusValidatorStep;
use Spryker\Zed\MerchantProductOptionDataImport\Business\Model\Step\MerchantProductOptionGroupWriterStep;
use Spryker\Zed\MerchantProductOptionDataImport\Business\Model\Step\MerchantReferenceValidatorStep;
use Spryker\Zed\MerchantProductOptionDataImport\Business\Model\Step\ProductOptionGroupKeyToIdProductOptionGroupStep;

/**
 * @method \Spryker\Zed\MerchantProductOptionDataImport\MerchantProductOptionDataImportConfig getConfig()
 * @method \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerTransactionAware createTransactionAwareDataSetStepBroker($bulkSize = null)
 * @method \Spryker\Zed\DataImport\Business\Model\DataImporter getCsvDataImporterFromConfig(\Generated\Shared\Transfer\DataImporterConfigurationTransfer $dataImporterConfigurationTransfer)
 */
class MerchantProductOptionDataImportBusinessFactory extends DataImportBusinessFactory
{
    public function getMerchantProductOptionGroupDataImport(): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->getMerchantProductOptionGroupDataImporterConfiguration(),
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();

        $dataSetStepBroker->addStep($this->createProductOptionGroupKeyToIdProductOptionGroupStep());
        $dataSetStepBroker->addStep($this->createApprovalStatusValidatorStep());
        $dataSetStepBroker->addStep($this->createMerchantReferenceValidatorStep());
        $dataSetStepBroker->addStep($this->createMerchantProductOptionGroupWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    public function createProductOptionGroupKeyToIdProductOptionGroupStep(): DataImportStepInterface
    {
        return new ProductOptionGroupKeyToIdProductOptionGroupStep();
    }

    public function createMerchantReferenceValidatorStep(): DataImportStepInterface
    {
        return new MerchantReferenceValidatorStep();
    }

    public function createApprovalStatusValidatorStep(): DataImportStepInterface
    {
        return new ApprovalStatusValidatorStep();
    }

    public function createMerchantProductOptionGroupWriterStep(): DataImportStepInterface
    {
        return new MerchantProductOptionGroupWriterStep();
    }
}
