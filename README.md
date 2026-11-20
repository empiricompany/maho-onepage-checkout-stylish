# MM_OnepageCheckoutStylish

Restyles the one-step checkout of the storefront without touching the engine: the
steps in the left column, the order summary in the right one, three styles to choose
from and a few options that work the same with any of them. The colours always come
from the theme.

![The three styles](docs/onepage-checkout-styles.gif)

Every setting lives under **System > Configuration > Design > One-Step Checkout
Style** and can be set per website and per store view.

## Requirements

- Maho with the one-step checkout enabled (`checkout/options/onestep_checkout_enabled`).
- PHP 8.5 or newer.

## Install

```sh
composer require empiricompany/maho-onepage-checkout-stylish
./maho cache:flush
```

## Configuration

| Field | Config path | Default | What it does |
| --- | --- | --- | --- |
| Enable the styled one-step checkout | `design/onepagecheckoutstylish/enabled` | `1` | Off leaves the checkout exactly as the engine draws it |
| Style | `design/onepagecheckoutstylish/style` | `divider` | `divider`, `plain` or `boxed` |
| Step marker | `design/onepagecheckoutstylish/step_marker` | `steps` | The number of the step (`steps`), the icon of the theme (`icons`) or nothing (`none`) |
| Hide the line under the step titles | `design/onepagecheckoutstylish/hide_title_lines` | `1` | The titles read as plain text, or keep the accent hairline of the base theme |
| Input labels | `design/onepagecheckoutstylish/label_style` | `placeholders` | The label inside the field (`placeholders`) or above it (`labels`) |
| Street lines | `design/onepagecheckoutstylish/street_layout` | `standard` | One row per address line (`standard`), or the second line as the civic number of the first (`civic`) |
| Product image in the order summary | `design/onepagecheckoutstylish/product_images` | `1` | The thumbnail of the theme beside the product name |
| Quantity as a badge on the image | `design/onepagecheckoutstylish/product_qty_badge` | `1` | Needs the product image: the quantity moves onto the thumbnail and the row keeps only the total |

From the CLI:

```sh
./maho config:get design/onepagecheckoutstylish/style
./maho config:set design/onepagecheckoutstylish/style boxed --scope stores --scope-id 1
./maho cache:flush
```

## Styles

| Style | What you see |
| --- | --- |
| `divider` | White page, the right half painted as a panel, the summary at its top |
| `plain` | Tinted page, the steps free on it, only the summary in a white card |
| `boxed` | Tinted page, every step in a white box, the order button full width |

The style is the skin only: the order of the page never changes, and every option
below works the same with all three.

## Input labels

![Input labels](docs/onepage-checkout-labels.gif)

`placeholders` moves the label inside the field, the asterisk of the required ones
included. A select has no room for a placeholder, so its label goes into the empty
option of the list; radio groups and checkboxes keep their labels.

## Street lines

![Street lines](docs/onepage-checkout-street-lines.gif)

`civic` turns the second street line into the civic number of the first: same row,
half each, required and translated. With one street line on the address there is
nothing to turn into a civic number and the form stays as it is.

## Step marker and title line

![Step marker](docs/onepage-checkout-step-marker.gif)

The counter follows the order of the page and skips both the summary and the hidden
shipping block. Turning off the line under the titles brings back the accent hairline
of the base theme.

## Product image and quantity

![Product image and quantity](docs/onepage-checkout-product-image.gif)

The thumbnail sits in a square tile like the one of the cart. With the quantity as a
badge the unit price and the quantity columns go away: the row keeps the product and
the total, divided from the next product by a dashed line. Off, the summary keeps the
row of the engine.

## Verify

1. Open a checkout with a few products in the cart, at a desktop width and at 402px.
2. Switch the style: only the look changes, the sections stay where they are.
3. Scroll: the order summary stays in view while the steps scroll.
4. Turn the module off: the checkout of the engine comes back untouched.

## License

OSL-3.0. See `LICENSE.txt`. The template of the order summary row derives from
`checkout/onepage/review/item.phtml` of Maho and keeps its AFL-3.0 license.
