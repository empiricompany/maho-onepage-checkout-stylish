# MM_OnepageCheckoutStylish

Restyles the one-step checkout of the storefront without touching the engine: every
step in the left column, the order summary in the right one, two styles to choose
from, and a few options that work the same with either.

Every setting lives under **System > Configuration > Design > One-Step Checkout
Style** and can be set per website and per store view.

## Requirements

- Maho with the one-step checkout enabled
  (`checkout/options/onestep_checkout_enabled`).
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
| Style | `design/onepagecheckoutstylish/style` | `divider` | The look: `divider`, `plain` or `boxed` |
| Step marker | `design/onepagecheckoutstylish/step_marker` | `steps` | What marks each step heading: its number, counted in reading order (`steps`), the icon of the theme (`icons`) or nothing (`none`) |
| Hide the line under the step titles | `design/onepagecheckoutstylish/hide_title_lines` | `1` | The titles read as plain text, or keep the accent hairline of the base theme |
| Input labels | `design/onepagecheckoutstylish/label_style` | `placeholders` | The label inside the field, as its placeholder (`placeholders`) or above it (`labels`) |
| Street lines | `design/onepagecheckoutstylish/street_layout` | `standard` | One row per address line (`standard`), or the second line turned into the civic number of the first, on the same row and required (`civic`) |
| Product image in the order summary | `design/onepagecheckoutstylish/product_images` | `1` | The thumbnail of the theme beside the product name in the summary |
| Quantity as a badge on the image | `design/onepagecheckoutstylish/product_qty_badge` | `1` | Needs the product image. On, the quantity sits on the thumbnail and the row keeps only the total: the quantity and the unit price columns go away |

The order of the page is always the same: every step in the left column, the order
summary in the right one, staying in view while the steps scroll. The style changes
only the look; the options above work the same with either style.

| Style | What you see |
| --- | --- |
| `divider` | White page, the right half painted as a panel, the order summary at its top, level with the page title |
| `plain` | Tinted page, the steps free on it and the fields with the look of the theme, only the order summary in a white card |
| `boxed` | Tinted page, every step in a white box with a hairline and bordered fields, the order summary closed by a full-width pill button |

From the CLI:

```sh
./maho config:get design/onepagecheckoutstylish/style
./maho config:set design/onepagecheckoutstylish/style boxed --scope stores --scope-id 1
./maho cache:flush
```

## What each option changes

**Style.** The skin only: `divider` leaves the page white and paints the summary half as
a panel, `plain` tints the page and leaves the steps free with only the order summary in
a card, `boxed` tints the page and puts every step in a white box. The colours are always
the ones of the theme. Nothing about the positions changes.

**Step marker.** The number of the step follows the order of the page and skips both
the summary and the hidden shipping block.

**Input labels.** With `placeholders` the label leaves the space above the field and
its text goes inside the field, with the asterisk of the required ones. A select has no
room for a placeholder, so its label moves into the empty option of the list; when the
list has no empty option the label stays above it. Radio groups, checkboxes and hidden
fields keep their labels.

**Street lines.** `civic` renames the second street line to "Numero Civico" (translated),
puts it beside the first one, half each, and makes it required. It needs two street
lines on the address: with one line there is nothing to turn into a civic number and
the form stays as it is.

**Product image.** The summary row gets the thumbnail of the theme, in a square tile
like the one of the cart. Off, the summary keeps the row of the engine: the module
does not take over that part of the page at all.

**Quantity as a badge.** It needs the product image, there would be nothing to put the
badge on without it. On, the quantity leaves its column for a round badge on the corner
of the thumbnail, and the row keeps the product and the total only: the unit price and
the quantity columns go away.

**Hide the line under the step titles.** Off brings back the accent hairline the base
theme draws under every heading of the checkout.

## Verify

1. Open a checkout with a few products in the cart, at a desktop width and at 402px.
2. Switch the style: only the look changes, the sections stay where they are.
3. Scroll: the order summary stays in view while the steps scroll.
4. Turn the product image off: the summary row loses the thumbnail and nothing else.
5. Turn the module off: the checkout of the engine comes back untouched.

## License

OSL-3.0. See `LICENSE.txt`. The template of the order summary row derives from
`checkout/onepage/review/item.phtml` of Maho and keeps its AFL-3.0 license.
